<?php

namespace App\Http\Livewire;

use App\Models\Company;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class DeleteCompany extends Component
{
    /**
     * Indicates if company deletion is being confirmed.
     *
     * @var bool
     */
    public $confirmingCompanyDeletion = false;

    /**
     * The user's current password.
     *
     * @var string
     */
    public $password = '';

    /**
     * Confirm that the user would like to delete their company.
     *
     * @return void
     */
    public function confirmCompanyDeletion()
    {
        $this->resetErrorBag();

        $this->password = '';

        $this->dispatchBrowserEvent('confirming-delete-company');

        $this->confirmingCompanyDeletion = true;
    }

    /**
     * Delete the current company.
     */
    public function deleteCompany(Request $request, StatefulGuard $auth)
    {
        $this->resetErrorBag();

        if (! Hash::check($this->password, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'password' => [__('This password does not match our records.')],
            ]);
        }

        /**
         * @var Company $company
         **/
        $company = Auth::user()
            ->company()
            ->first();

        DB::transaction(function () use ($company) {
            $company->users()->each(function ($user) {
                $user
                    ->forceFill([
                        'active' => 0,
                    ])
                    ->save();

                if ($user->meetingConfig && $user->meetingConfig->active) {
                    $user->meetingConfig->active = 0;
                    $user->meetingConfig->save();
                }
            });
            if (isset($company->stripe_id)) {
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                if ($subscription = $company->subscription()) {
                    $subscription->cancel();
                }

                //                $subscription = \Stripe\Subscription::retrieve('default');
                //                $subscription->cancel();
                $company
                    ->forceFill([
                        'active' => 0,
                    ])
                    ->save();
            }
        });

        $auth->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.delete-company');
    }
}
