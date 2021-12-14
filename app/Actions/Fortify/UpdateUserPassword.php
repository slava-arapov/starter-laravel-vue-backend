<?php

/** @noinspection DuplicatedCode */

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param mixed $user
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($user, array $input): void
    {
        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make($input, [
            'current_password' => ['required', 'string'],
            'password' => $this->passwordRules(),
        ])->after(
            /**
             * @param \Illuminate\Validation\Validator $validator
             * @psalm-suppress PossiblyInvalidArgument
             */
            function ($validator) use ($user, $input) {
                if (!isset($input['current_password']) || !Hash::check($input['current_password'], $user->password)) {
                    $validator->errors()->add('current_password', __('The provided password does not match your current password.'));
                }
            }
        );

        $validator->validateWithBag('updatePassword');

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
