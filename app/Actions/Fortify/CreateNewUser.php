<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\TwoFactorAuthenticationProvider;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    protected $twoFactor;

    public function __construct(TwoFactorAuthenticationProvider $twoFactor)
    {
        $this->twoFactor = $twoFactor;
    }

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        // Gerar e salvar o two_factor_secret assim que o usuário é criado
        $user->two_factor_secret = $this->twoFactor->generateSecretKey();
        $user->two_factor_confirmed_at = now();
        $user->save();

        return $user;
    }
}
