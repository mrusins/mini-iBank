<?php

namespace App\Actions\Fortify;

use App\Models\Account;
use App\Models\accounts;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input)
    {
        $uniq = uniqid();
        $rand = rand(10000, 99999);
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        Account::create([
            'uniqId' => $uniq,
            'account' => 'LVHAHA'.$rand,
            'amount' => 100,
            'currency' => 'EUR'
        ]);

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'uniqId' => $uniq,
            'password' => Hash::make($input['password']),
        ]);
    }
}
