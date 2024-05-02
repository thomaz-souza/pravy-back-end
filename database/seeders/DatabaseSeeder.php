<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Address;

class DatabaseSeeder extends Seeder
{
    /**
     * 
     * Propaga o banco de dados do aplicativo.
     */
    public function run(): void
    {
        User::factory()->count(5)->create();

        User::all()->each(function ($user) {
            Address::factory()->count(rand(1, 3))->create(['user_id' => $user->id]);
        });
    }
}
