<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seedUsers = [
            [
                'id' => 1,
                'name' => 'Ad Ministrator',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Password1'),
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Jono',
                'email' => 'jono@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Password1'),
                'created_at' => now(),
            ],
        ];
        foreach ($seedUsers as $user) {
            User::create($user);
        }
    }
}
