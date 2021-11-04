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
        $this->AstronautPermissions();

    }

    public function ManagerPermissions()
    {
        $managerPermissions = [
            'edit-public-playlist', 'delete-public-playlist', 'view-public-playlist',
            'playlist-create', 'track-list', 'track-create', 'track-edit', 'track-delete',
            'user-list', 'user-edit', 'user-delete', 'user-create', 'edit-own-profile'
        ];
        $manager = Role::create(['name' => "Manager"]);


        $manager->syncPermissions($managerPermissions);
        $user = User::find(5);
        $user->assignRole(['Manager']);
        $user = User::find(10);
        $user->assignRole(['Manager']);
    }

    public function AstronautPermissions()
    {
        $astroPermissions = [
            'edit-own-profile', 'playlist-create', 'view-own-playlist',
            'view-public-playlist', 'delete-own-playlist',
        ];
        $astronaut = Role::create(['name' => "Astronaut"]);
        $astronaut->syncPermissions($astroPermissions);
        $user = User::find(6);
        $user->assignRole(['Astronaut']);


    }
}
