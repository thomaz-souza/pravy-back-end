<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * A senha usada pela Factory.
     */
    protected static ?string $password;
    protected $model = User::class;

    /**
     * Define o estado padrão do model
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name, // Gera um nome e sobrenome aleatórios
            'email' => $this->faker->unique()->safeEmail, //Gera um email aleatório
            'email_verified_at' => now(), // Define a data do processamento da factory
            'password' => static::$password ??= Hash::make('password'), //Define uma senha aleatória com hash
            'remember_token' => Str::random(10), // Define um token aleatório
        ];
    }

    /**
     * Indica que o email do model deveria ser não verificado
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
