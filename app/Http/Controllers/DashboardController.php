<?php

namespace App\Http\Controllers;

use App\Exports\ActivityExport;
use App\Exports\BillingExport;
use App\Exports\BillingFundingExport;
use App\Exports\RewardsExport;
use App\Exports\RewardStatsExport;
use App\Exports\UserStatsExport;
use App\Exports\WalletExport;
use App\Models\Reward;
use App\Models\Transaction;
//use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use JamesMills\LaravelTimezone\Facades\Timezone;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    // note, not to be confused with Kudos Feed which was previously called Dashboard.

    public function show()
    {
        $company = Auth::user()->company;

        return view('dashboard.show', ['company' => $company]);
    }

    public function billing()
    {
        $company = Auth::user()->company;
        // $checkout = Auth::user()->company
        // ->checkout(['price_1J5JfNCioUdMUSQtlkrwHiHp' => 15],
        //     [
        //         'success_url' => route('billing'),
        //         'cancel_url' => route('billing'),
        //     ]);

        if (auth()->user()->hasVerifiedEmail()) {
            return view('dashboard.billing', ['company' => $company]);
        }

        return view('user.email-not-verified');
    }

    public function exportData()
    {
        $company = Auth::user()->company;
        foreach ($company->transactions->unique()->sortByDesc('created_at')->take(500) as $key => $t) {
            if ($t->amount > 0) {
                $amount = number_format($t->amount);
            } else {
                $amount = '-'.(number_format(abs((float) $t->amount)));
            }
            $data = json_decode($t->data);
            if (isset($data->giver)) {
                $transaction = getReplacedWordOfKudos();
            } else {
                $transaction = 'Redemption ';
            }
            if (isset($data->from_id)) {
                $user = $data->giver->name;
            } else {
                $user = $t->user->name;
            }

            $note = $t->user->name.' '.$t->note;
            $users[] = [
                'amount' => $amount,
                'transaction'   => $transaction,
                'associated user' => $user,
                'description'   => $note,
                'date'   => Timezone::convertToLocal($t->created_at, 'm/d/Y'),
            ];
        }

        if (isset($users)) {
            return Excel::download(new ActivityExport($users), getReplacedWordOfKudos().' Activity - '.Carbon::now()->format('m.d.y').' - '.$company->name.'.xlsx');
        }

        session()->flash('flash.banner', 'No '.getReplacedWordOfKudos().' Activity Found ..');

        return redirect()->back();
    }

    public function export()
    {
        $company = Auth::user()->company;

        foreach ($company->transactions->unique()->sortByDesc('created_at')->where('type', '=', 2) as $key => $t) {
//        $users = [];
            if ($t->amount > 0) {
                $amount = (number_format((float) $t->amount / 100, 2));
            } else {
                $amount = '-'.(number_format(abs((float) $t->amount / 100), 2));
            }
            if ($t->redemption) {
                $currency = currencyNumber($t->redemption->value, $t->redemption->currency);
            } else {
                $currency = (number_format((float) $t->amount, 2));
            }
            $data = json_decode($t->data);
            $note = $t->user->name.' '.$t->note;
            $users[] = [
                [
                    'amount(USD)'  => $amount,
                    'amount'  => $currency,
                    'rewards' => json_decode(json_decode($t->data)->data)->type === 'default' ? 'Partner Reward' : json_decode(json_decode($t->data)->data)->type,
                    'description'    => $note,
                    'email'   => $t->user->email,
                    'date'    => Timezone::convertToLocal($t->created_at, 'm/d/Y'),
                ],
            ];
        }
        if (isset($users)) {
            return Excel::download(new BillingExport($users), 'Reward Redemption Activity - '.Carbon::now()->format('m.d.y').' - '.$company->name.'.xlsx');
        }

        session()->flash('flash.banner', 'No Reward Redemption Activity Found ..');

        return redirect()->back();
    }

    public function export_funding()
    {
        $company = Auth::user()->company;

        foreach ($company->companyTransactions->unique()->sortByDesc('created_at')->where('active', 1) as $key => $t) {
            if ($t->type == 1) {
                $amount = (number_format((float) $t->amount, 2));
            } else {
                $amount = '-'.(number_format(abs((float) $t->amount), 2));
            }

            if ($t->type == 1) {
                $currency = (number_format((float) $t->amount, 2));
                $description = $t->user->name.' funded $'.(number_format((float) $t->amount, 2)).' to '.appName();
            } else {
                if ($t->redemption) {
                    $currency = currencyNumber($t->redemption->value, $t->redemption->currency);
                    $description = $t->user->name.' redeemed '.getReplacedWordOfKudos().' for '.$currency.
                        ' of Partner Rewards';
                } else {
                    $currency = (number_format((float) $t->amount, 2));
                    $description = $t->user->name.' redeemed '.getReplacedWordOfKudos().' for '.$currency.
                        ' of Partner Rewards';
                }
            }

            $funding[] = [
                [
                    'amount(USD)'      => $amount,
                    'amount'      => $currency,
                    'description' => $description,
                    'date' => Timezone::convertToLocal($t->created_at, 'm/d/Y'),
                ],
            ];
        }
        if (isset($funding)) {
            return Excel::download(new BillingFundingExport($funding), 'Funding History - '.Carbon::now()->format('m.d.y').' - '.$company->name.'.xlsx');
        }

        session()->flash('flash.banner', 'No funding History Found ..');

        return redirect()->back();
    }

    public function export_wallet()
    {
        foreach (Transaction::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get() as $key=>$t) {
            if ($t->amount > 0) {
                $amount = number_format($t->amount);
            } else {
                $amount = '-'.number_format(abs($t->amount));
            }
            $data = json_decode($t->data);
            if (isset($data->giver)) {
                $transaction = getReplacedWordOfKudos();
            } else {
                $transaction = 'Redemption';
            }
            if (isset($data->from_id)) {
                $user = $data->giver->name;
            } else {
                $user = $t->user->name;
            }

            $wallet[] = [
                [
                    'amount' => $amount,
                    'transaction'=>$transaction,
                    'associated user' => $user,
                    'description' => $t->note,
                    'date' => Timezone::convertToLocal($t->created_at, 'm/d/Y'),
                ],

            ];
        }
        if (isset($wallet)) {
            return Excel::download(new WalletExport($wallet), 'Recent Transaction History -'.Carbon::now()->format('m.d.y').' - '.Auth::user()->company->name.'.xlsx');
        } else {
            session()->flash('flash.banner', 'No Recent Transaction History Found ..');

            return redirect()->back();
        }
    }

    public function export_reward()
    {
        foreach (auth()->user()->company->redemptions()->orderBy('created_at', 'desc')->get() as $r) {
            if (! ($r->marked_as_unable_to_furfill || $r->is_rejected) && ! $r->is_pending) {
                if ($r->confirmed_reciept) {
                    $status = 'Sent';
                } else {
                    $status = 'Not Sent';
                }
            } elseif ($r->is_pending) {
                $status = 'Pending';
            } elseif ($r->is_rejected || $r->marked_as_unable_to_furfill) {
                $status = 'Denied';
            } else {
                $status = '-';
            }

            if (isset(json_decode(json_decode($r->data)->tango_data)->items[0]->currencyCode)) {
                $currency = json_decode(json_decode($r->data)->tango_data)->items[0]->currencyCode;
            } else {
                $currency = 'USD';
            }
            if ($r->is_pending) {
                $approval = 'Pending';
            } else {
                if ($r->is_rejected || $r->marked_as_unable_to_furfill) {
                    $approval = 'Rejected';
                } else {
                    $approval = 'Approved';
                }
            }
            $rewards[] = [
                [
                    'recipient_name' => $r->user->name,
                    'reward_title' => data_get(json_decode($r->data), 'title'),
                    getReplacedWordOfKudos() => strlen($r->cost) <= 3 ? $r->cost : substr($r->cost, 0, -3).','.substr($r->cost, -3),
                    'amount' => $r->value,
                    'currency' => $currency,
                    'status' => $status,
                    'approval' => $approval,
                    'unique_redemption_code' => $r->redemption_code,
                    'purchase_date' => Timezone::convertToLocal($r->created_at, 'm/d/Y'),
                ],
            ];
        }
        if (isset($rewards)) {
            return Excel::download(new RewardsExport($rewards), 'Reward Redemptions - '.Carbon::now()->format('m.d.y').' - '.Auth::user()->company->name.'.xlsx');
        }

        session()->flash('flash.banner', 'No Rewards Redemptions Found ..');

        return redirect()->back();
    }

    public function export_reward_stats()
    {
        $reward = Reward::forCompany()
            ->with('recent_redemption', 'recent_redemption.user')->get();
        foreach ($reward as $r) {
            $rewards[] = [
                [
                    'title' => $r->title,
                    'amount_in '.getReplacedWordOfKudos()  => $r->cost ? $r->cost : 'Variable',
                    'stock_left' => $r->type !== 'Custom Reward' ? 'Unlimited' : ($r->enable_inventory_tracking ? $r->stock_amount : 'N/A'),
                    'amount_redeemed' => $r->RewardCount ? $r->RewardCount : '0',
                    'type' => $r->type == 'Custom Reward' ? $r->type : 'Partner Rewards',
                    'currency' => $r->currency,
                    'last_redeemed_by' => data_get($r, 'recent_redemption.user') ? 'By '.$r->recent_redemption->user->name.' at '.defaultDateFormat($r->recent_redemption->created_at) : 'N/A',
                ],
            ];
        }
        if (isset($rewards)) {
            return Excel::download(new RewardStatsExport($rewards), 'Reward Stats - '.Carbon::now()->format('m.d.y').' - '.Auth::user()->company->name.'.xlsx');
        }

        session()->flash('flash.banner', 'No Redemptions Found ...');

        return redirect()->back();
    }

    public function export_user_stats()
    {
        $user = auth()->user()->company->users()->orderby('name')->get();
        foreach ($user as $u) {
            $users[] = [
                [
                    'name' => $u->name,
                    'email'  => $u->email,
                    'available '.getReplacedWordOfKudos().' to Spend' => number_format($u->points),
                    'available '.getReplacedWordOfKudos().' to Give' => number_format($u->points_to_give),
                    'last '.getReplacedWordOfKudos().' Sent At' => $u->formatted_recent_kudos_sent_at,
                    'last Login At' => $u->formatted_last_login_at,
                ],
            ];
        }
        if (isset($users)) {
            return Excel::download(new UserStatsExport($users), 'User Stats - '.Carbon::now()->format('m.d.y').' - '.Auth::user()->company->name.'.xlsx');
        }

        session()->flash('flash.banner', 'No User Stats Found ...');

        return redirect()->back();
    }
}
