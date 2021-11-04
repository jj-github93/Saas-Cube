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
                'id' => 5,
                'name' => 'Jono',
                'email' => 'jono@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Password1'),
                'created_at' => now(),
            ],
            [
                'id' => 6,
                'name' => 'Adrian Gould',
                'email' => 'adrian.gould@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Password1'),
                'created_at' => now(),
            ],
            [
                'id' => 10,
                'name' => 'Eileen Dover',
                'email' => 'eileen.dover@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Password1'),
                'created_at' => now(),
            ],
//            [
//                'id' => 11,
//                'name' => "Jacques d'Carre",
//                'email' => 'jacques.dcarre@example.com',
//                'email_verified_at' => now(),
//                'password' => Hash::make('Password1'),
//                'created_at' => now(),
//            ],
//            [
//                'id' => 12,
//                'name' => 'Russell Leaves',
//                'email' => 'russell.leaves@example.com',
//                'email_verified_at' => now(),
//                'password' => Hash::make('Password1'),
//                'created_at' => now(),
//            ],
//            [
//                'id' => 13,
//                'name' => 'Ivana Vinn',
//                'email' => 'ivanna.vinn@example.com',
//                'email_verified_at' => now(),
//                'password' => Hash::make('Password1'),
//                'created_at' => now(),
//            ],
//            [
//                'id' => 14,
//                'name' => 'Win Doh',
//                'email' => 'win.doh@example.com',
//                'email_verified_at' => now(),
//                'password' => Hash::make('Password1'),
//                'created_at' => now(),
//            ],
        ];
        foreach ($seedUsers as $user) {
            User::create($user);
        }
    }
}
