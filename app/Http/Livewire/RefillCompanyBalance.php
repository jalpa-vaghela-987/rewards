<?php

namespace App\Http\Livewire;

use App\Models\CompanyTransaction;
use Livewire\Component;

class RefillCompanyBalance extends Component
{
    public $amount;
    public $balance;

    public $company;

    private $card = false;
    private $payment_method = false;

    public $card_brand;
    public $confirmingSend = false;
    public $last4 = false;

    public $password = '';
    public $button = false;

    public function render()
    {
        return view('livewire.refill-company-balance');
    }

    public function mount()
    {
        $this->balance = $this->company->balance;

        //gets the right payment method
        if ($this->company->hasDefaultPaymentMethod()) {
            $this->payment_method = $this->company->defaultPaymentMethod();
        } elseif ($this->company->paymentMethods()) {
            $this->payment_method = $this->company->paymentMethods()->last();
        } else {
        }

        if ($this->payment_method && $this->payment_method->card) {
            $this->card = $this->payment_method->card;
            $this->card_brand = $this->card->brand;
            $this->last4 = $this->card->last4;
        }
    }

    public function setUpStripe()
    {
        $data = $this->validate([
            'amount' => ['required', 'integer', 'min:5', 'max:10000'],
        ]);

        $amt = $data['amount'];
        $ct = new CompanyTransaction();
        $ct->hash = sha1(time().rand(1, 999999));
        $ct->user()->associate(auth()->user()); // think something for this only
        $ct->company()->associate($this->company);
        $ct->amount = $amt;
        $ct->type = 1;
        $ct->data = json_encode($this->company->withoutRelations());

        if (! $this->company->hasStripeId()) {
            $ct->stripe_data = json_encode(
                $this->company->createAsStripeCustomer()
            );
        } else {
            $ct->stripe_data = json_encode($this->company->asStripeCustomer());
        }

        $ct->save();
        //notice it is not set active. This allows the link here to be the test of if it went through

        //session()->flash('message', 'Transaction Test');

        if (auth()->user()->developer === 1) {
            $this->redirect(url('/payments/refill/'.$ct->hash));
        } else {
            $checkout = $this->company->allowPromotionCodes()->checkout(
                [env('STRIPE_PRICE_REFILL_ID') => $amt],
                [
                    'success_url' => url('/payments/refill/'.$ct->hash),
                    'cancel_url' => route('billing'),
                ]
            );

            $this->button = htmlspecialchars(
                $checkout->button('Checkout with Stripe!', [
                    'class' => 'sm:inline-flex w-full sm:w-auto inline items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 stripe_checkout_button',
                ])
            );

            $this->confirmingSend = true;
        }
    }
}
