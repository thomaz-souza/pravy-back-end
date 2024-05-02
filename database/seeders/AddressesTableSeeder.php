<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Address;
use App\Models\User;


class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = User::all();
        foreach ($users as $user) {
            Address::factory()->count(rand(1, 3))->create(['user_id' => $user->id]);
        }
    }
}
