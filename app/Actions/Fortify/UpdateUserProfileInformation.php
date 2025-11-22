<?php
// app/Actions/Fortify/UpdateUserProfileInformation.php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        // Validation rules
        $rules = [
            'username' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('users')->ignore($user->id)
            ],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ];

        // No WA hanya untuk mentor
        if ($user->hasRole('mentor')) {
            $rules['no_wa'] = [
                'nullable',
                'string',
                'max:20',
                'regex:/^[0-9+\-\s()]+$/' // Format nomor telepon
            ];
        }

        Validator::make($input, $rules)->validateWithBag('updateProfileInformation');

        // Update photo jika ada
        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        // Update username
        $user->forceFill([
            'username' => $input['username'],
        ])->save();

        // Update no_wa untuk mentor
        if ($user->hasRole('mentor') && $user->mentor) {
            $user->mentor->forceFill([
                'no_wa' => $input['no_wa'] ?? null,
            ])->save();
        }
    }
}
