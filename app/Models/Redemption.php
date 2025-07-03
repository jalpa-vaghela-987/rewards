<?php

namespace App\Models;

use App\Notifications\RedeemedGiftCard;
use App\Notifications\RejectedGiftCard;
use App\Notifications\UnableToFulfillGiftCard;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class Redemption extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }

    public function calculatedAmount($cost = null, $conversionRate = 1)
    {
        $conversionRate = $conversionRate > 0 ? $conversionRate : 1;

        return round(($cost ?? $this->cost) / getCustomizeNumberOfKudos() * $conversionRate);
    }

    public function scopePending($q)
    {
        return $q->where(function ($q) {
            $q->whereNotIn('redemptions.id', auth()->user()->company->redemptions()->processed()->pluck('redemptions.id'))
                ->orWhere(function ($q) {
                    $q->where('is_rejected', false)->where('confirmed_reciept', false);
                });
        });
    }

    public function scopeProcessed($q)
    {
        return $q->where('tango_status', 'COMPLETE')
            ->orWhere(function ($q) {
                $q->where(function ($q) {
                    $q->where('is_approved', true)
                        ->where('is_rejected', false);
                })
                ->orWhere(function ($q) {
                    $q->where('is_auto_approved', true)
                        ->where('is_rejected', false);
                })
                ->orWhere(function ($q) {
                    $q->where('is_rejected', true)
                        ->orWhere('is_auto_approved', true)
                        ->orWhere('is_approved', true);
                })
                ->orWhere('marked_as_unable_to_furfill', true);
            });
    }

    public function createTransaction()
    {
        $reward = json_decode($this->data);

        $t = new Transaction;
        $t->user_id = $this->user_id;
        $t->redemption_id = $this->id;
        $t->note = 'Purchased '.$reward->title;
        $t->link = '/redemption/'.$this->id;
        $t->amount = -1 * (int) $this->cost;
        $t->type = 2;
        $t->data = json_encode($this);
        $t->save();
    }

    public function getIsProcessedAttribute()
    {
        return $this->tango_status === 'COMPLETE' || (
                $this->is_approved ||
                $this->is_auto_approved ||
                $this->is_rejected ||
                $this->marked_as_unable_to_furfill
            );
    }

    public function getIsPendingAttribute()
    {
        return ! $this->is_processed;
    }

    public function cancel($failingReason = null)
    {
        $this->user->points += $this->cost;
        $this->user->save();

        $this->is_approved = false;

        if ($failingReason) {
            $this->rejection_reason = $failingReason;
            $this->save();

            $this->marked_as_unable_to_furfill = true;

            $this->user->notify(new UnableToFulfillGiftCard($this, $failingReason));
        } else {
            $this->is_rejected = true;

            $this->user->notify(new RejectedGiftCard($this));
        }

        $this->save();
    }

    public function process()
    {
        $user = $this->user;
        $reward = $this->reward;
        $key = env('TANGO_API_KEY', '');
        $endpoint = env('TANGO_ENDPOINT', '');
        $platform = env('TANGO_PLATFORM', '');

        $conversionRate = 1.00;
        $tangoData = json_decode($reward->tango_data);
        $currency = 'USD';

        if (isset($tangoData, $tangoData->items)) {
            if ($tangoData->items[0]->currencyCode != 'USD') {
                if ($conversionRate = ConversionRate::reward($tangoData->items[0]->currencyCode)->base('USD')->first()) {
                    $conversionRate = $conversionRate->base_fx;
                }
                $currency = data_get($tangoData, 'items.0.currencyCode', 'USD');
            }
        }

        if ($reward->tango_utid != null && $this->value > 0) {
            $email_id = null;
            if (false) {
                $email_id = env('TANGO_HELLOTEAM_EMAIL_ID', null);
            } else {
                $email_id = env('TANGO_EMAIL_ID', null);
            }

            $user_email = $user->email; // added this to test tango templates
            if (env('DB_CONNECTION') == 'local') {
                $user_email = 'nick@perksweet.com';
            }

            $response = Http::withBasicAuth($platform, $key)
                ->post($endpoint.'orders', [
                    'accountIdentifier'  => env('TANGO_ACCOUNT_ID'),
                    'sendEmail'          => true,
                    'customerIdentifier' => env('TANGO_CUSTOMER_ID'),
                    'amount'             => $this->value,
                    'notes'              => "Purchased by $user->name for $this->cost ".getReplacedWordOfKudos().' at '.now(),
                    'utid'               => $reward->tango_utid,
                    'etid'               => $email_id,
                    'message'            => getReplacedWordOfKudos(), // Points/Kudos value!
                    'recipient'          => [
                        'email'              => $user_email,
                        'firstName'          => substr($user->name, 0, 90),
                        //"lastName"           => appName(), // name of whitelabel!
                    ],
                    'sender'            => [
                        'firstName' => appName(),
                    ],

                ]);

            $body = (json_decode($response->body()));
            //dd($body);

            if (isset($body->status) && $body->status === 'COMPLETE') {
                $this->tango_order_id = $body->referenceOrderID;
                $this->tango_customer_id = $body->customerIdentifier;
                $this->tango_account_id = $body->accountIdentifier;
                $this->tango_created_at = $body->createdAt;
                $this->tango_status = $body->status;
                $this->tango_amount = $body->amountCharged->value;
                $this->tango_utid = $body->utid;
                $this->tango_reward_name = $body->rewardName;
                $this->tango_notes = $body->notes;
                $this->redemption_instructions = $reward->tango_redemption_instructions;

                if (isset($body->reward->redemptionInstructions)) {
                    $this->tango_directions = $body->reward->redemptionInstructions;
                }

                // checks a few methods for which type of GC
                $hold2 = 'Redemption URL';
                $hold3 = 'Claim Code';
                $hold4 = 'PIN';
                $hold5 = 'Card Number';
                $hold6 = 'Anspråkskod';
                $hold7 = 'Codigo';
                $hold8 = 'Claim Code (Chèque-Cadeau)';
                $hold9 = 'Code Cadeau';
                $hold10 = 'Claim Code (Buono Regalo)';
                $hold11 = 'Einlösungs-URL';
                $hold12 = 'URL de Remboursement';
                $hold13 = 'Inwisselings-URL';
                $hold14 = 'URL de Resgate';
                $hold15 = 'URL de Canje';
                $hold16 = 'Tegoedboncode';
                //$test = reset($body->reward->credentials);
                //dd($test);
                if (isset($body->reward->credentials->$hold2)) {
                    $this->tango_link = $body->reward->credentials->$hold2;
                } elseif (isset($body->reward->credentials->$hold3)) {
                    $this->tango_claim_code = $body->reward->credentials->$hold3;
                } elseif (isset($body->reward->credentials->$hold4) && isset($body->reward->credentials->$hold5)) {
                    $this->tango_pin = $body->reward->credentials->$hold4;
                    $this->tango_card_number = $body->reward->credentials->$hold5;
                } elseif (isset($body->reward->credentials->$hold6)) {
                    $this->tango_claim_code = $body->reward->credentials->$hold6;
                } elseif (isset($body->reward->credentials->$hold7)) {
                    $this->tango_claim_code = $body->reward->credentials->$hold7;
                } elseif (isset($body->reward->credentials->$hold8)) {
                    $this->tango_claim_code = $body->reward->credentials->$hold8;
                } elseif (isset($body->reward->credentials->$hold9)) {
                    $this->tango_claim_code = $body->reward->credentials->$hold9;
                } elseif (isset($body->reward->credentials->$hold10)) {
                    $this->tango_claim_code = $body->reward->credentials->$hold10;
                } elseif (isset($body->reward->credentials->$hold11)) {
                    $this->tango_claim_code = $body->reward->credentials->$hold11;
                } elseif (isset($body->reward->credentials->$hold12)) {
                    $this->tango_claim_code = $body->reward->credentials->$hold12;
                } elseif (isset($body->reward->credentials->$hold13)) {
                    $this->tango_claim_code = $body->reward->credentials->$hold13;
                } elseif (isset($body->reward->credentials->$hold14)) {
                    $this->tango_claim_code = $body->reward->credentials->$hold14;
                } elseif (isset($body->reward->credentials->$hold15)) {
                    $this->tango_claim_code = $body->reward->credentials->$hold15;
                } elseif (isset($body->reward->credentials->$hold16)) {
                    $this->tango_claim_code = $body->reward->credentials->$hold16;
                } else {
                    $test = reset($body->reward->credentials);
                    $this->tango_claim_code = $test;

                    //$reason = 'Gift Card provider did not authorize sale. Please try again or choose another provider. (412)';
                    //$this->cancel($reason);
                    //return $reason;
                }
            } else {
                Mail::to('sales@perksweet.com')->send(new \App\Mail\RedemptionError($body));

                $reason = 'Transaction did not complete. Gift Card provider did not authorize sale. Please try again or choose another provider. We apologize. (411)';

                $this->cancel($reason);

                return $reason;
            }

            $this->is_rejected = false;
            $this->is_approved = true;
            if (! $this->reward->approval_needed) {
                $this->is_auto_approved = true;
            } else {
                $this->is_auto_approved = false;
            }
            $this->marked_as_sent = true;
            $this->confirmed_reciept = true;
            $this->save();

            // tags the transaction from the company and updates the company balance.
            $comp = auth()->user()->company;
            $comp->balance = $comp->balance - round($this->value / $conversionRate, 2);
            $comp->balance_updated = now();
            $comp->cumulative_balance_spent = $comp->cumulative_balance_spent + round($this->value / $conversionRate, 2);
            $comp->last_balance_spent = round($this->value / $conversionRate, 2);
            $comp->save();
            $reward->stock_amount--;
            $reward->inventory_redeemed++;
            $reward->save();

            $ct = new CompanyTransaction;
            $ct->hash = substr(str_shuffle(sha1(time().rand(1, 999999))), 0, 10);
            $ct->user()->associate(auth()->user());
            $ct->company()->associate(auth()->user()->company);
            $ct->redemption()->associate($this);
            $ct->amount = round($this->value / $conversionRate, 2);
            $ct->type = 2;
            $ct->data = json_encode($this);
            if (! auth()->user()->company->hasStripeId()) {
                $ct->stripe_data = json_encode(auth()->user()->company->createAsStripeCustomer());
            } else {
                $ct->stripe_data = json_encode(auth()->user()->company->asStripeCustomer());
            }
            $ct->active = 1;
            $ct->transaction_sucessful = now();
            $ct->save();
        } elseif ($reward->is_custom) {
            if ($reward->enable_inventory_tracking) {
                if ($reward->stock_amount < 1) {
                    $reason = 'It looks like your company ran out of this type of reward. Please contact a company administrator to refill on PerkSweet to allow redemption or choose another reward.';

                    $this->cancel($reason);

                    return $reason;
                }
            }

            $this->value = $this->calculatedAmount($this->cost, $conversionRate);

            $this->redemption_instructions = $reward->custom_redemption_instructions;

            $this->is_approved = true;
            $this->is_rejected = false;
            if (! $reward->approval_needed) {
                $this->is_auto_approved = true;
            }

            $this->save();
            $user->save();

//            if ($this->reward->enable_inventory_tracking) {
//            dd('wgdfheswghj');
            $this->reward->stock_amount--;

            $this->reward->inventory_redeemed++;
            $this->reward->save();
//            }
        }

        $this->createTransaction();

        $user->notify(new RedeemedGiftCard($this));

        return $this;
    }

    public function getIsCustomAttribute()
    {
        $this->loadMissing('reward');

        return $this->reward && data_get($this->reward, 'is_custom', false);
    }
}
