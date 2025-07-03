<?php

namespace App\Http\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm;

class UpdateProfileInfoForm extends UpdateProfileInformationForm
{
    /**
     * The new avatar for the user.
     *
     * @var mixed
     */
    public $userObject;

    public function mount(User $user = null)
    {
        $this->userObject = $user
            ? User::find($user->id)->toArray()
            : Auth::user()
                ->withoutRelations()
                ->toArray();

        $this->state = $this->userObject;

        $this->state['birthday_date'] = 0;
        $this->state['birthday_month'] = 0;

        if ($birthdate = data_get($this->state, 'birthday')) {
            $birthdate = Carbon::parse($birthdate);
            $this->state['birthday_date'] = $birthdate->format('d');
            $this->state['birthday_month'] = $birthdate->format('m');
        }

        if ($anniversary = data_get($this->state, 'anniversary')) {
            $this->state['anniversary'] = Carbon::parse($anniversary)->format(
                'Y-m-d'
            );
        }
    }

    /**
     * Update the user's profile information.
     *
     * @param \Laravel\Fortify\Contracts\UpdatesUserProfileInformation $updater
     * @return void
     */
    public function updateProfileInformation(
        UpdatesUserProfileInformation $updater
    ) {
        $this->resetErrorBag();

        $birthdate = null;

        $month = $this->state['birthday_month'];
        $date = $this->state['birthday_date'];

        if ($month > 0 && $date <= 0) {
            $this->addError('birthday_date', 'Please select birthday date.');
        }

        if ($date > 0 && $month <= 0) {
            $this->addError('birthday_month', 'Please select birthday month.');
        }

        if ($month > 0 && $date > 0) {
            $birthdate = "2001-$month-$date";
        }

        $this->state['birthday'] = $birthdate;
        $this->state['anniversary'] =
            isset($this->state['anniversary']) &&
            $this->state['anniversary'] !== ''
                ? Carbon::parse($this->state['anniversary'])->toDateString()
                : null;
        $this->state['name'] = collect([
            $this->state['first_name'],
            $this->state['last_name'],
        ])
            ->filter()
            ->implode(' ');

        $updater->update(
            User::find($this->userObject['id']),
            $this->photo
                ? array_merge($this->state, ['photo' => $this->photo])
                : $this->state
        );

        $this->emit('saved');

        $this->emit('refresh-navigation-menu');
    }

    public function deletePhoto(User $u, $no)
    {
        if ($no == 0) {
        } else {
            $u->deleteProfilePhoto();
        }
        $this->emit('saved');

        $this->redirectRoute('profile.show', $u);
    }

    public function render()
    {
        return view('livewire.update-profile-info-form');
    }
}
