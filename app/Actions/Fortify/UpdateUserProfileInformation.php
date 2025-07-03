<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param mixed $user
     * @param array $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'initials'   => ['required'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo'      => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'position'   => ['required'],
            'currency'   => ['required'],
        ], [], [
            'position' => 'job title',
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $fullName = collect([data_get($input, 'first_name'), data_get($input, 'last_name')])->filter()->implode(' ');

            $user->forceFill([
                'initials'    => $input['initials'],
                'name'        => $fullName,
                'first_name'  => $input['first_name'],
                'last_name'   => $input['last_name'],
                'email'       => $input['email'],
                'birthday'    => $input['birthday'],
                'anniversary' => $input['anniversary'],
                'position'    => $input['position'],
                'currency'    => $input['currency'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param mixed $user
     * @param array $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $fullName = collect([data_get($input, 'first_name'), data_get($input, 'last_name')])->filter()->implode(' ');

        $user->forceFill([
            'name'              => $fullName,
            'first_name'        => $input['first_name'],
            'last_name'         => $input['last_name'],
            'email'             => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
