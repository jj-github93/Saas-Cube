<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use MongoDB\Driver\Manager;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->ManagerPermissions();
        Role::create(['name' => "Astronaut"]);

    }

    public function ManagerPermissions()
    {
        $managerPermissions = [
            'playlist-list', 'playlist-create', 'playlist-edit', 'playlist-delete',
            'track-list', 'track-create', 'track-edit', 'track-delete',
            'user-list', 'user-edit',
        ];
        $manager = Role::create(['name' => "Manager"]);


        $manager->syncPermissions($managerPermissions);
        $user = User::find(5);
        $user->assignRole([$manager]);
    }
}
