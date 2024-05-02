<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * 
     * Propaga o banco de dados do aplicativo.
     */
    public function run(): void
    {
        User::factory()->count(5)->create();
    }
}
