<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seedPermissions = [
            //Admin Permissions
//            'permission-list', 'permission-create', 'permission-edit', 'permission-delete',
            'user-list', 'user-create', 'user-edit', 'user-delete',
            'role-list', 'role-create', 'role-edit', 'role-delete',
            'genre-list', 'genre-create', 'genre-edit', 'genre-delete',
            'track-list', 'track-create', 'track-edit', 'track-delete',
            'playlist-list', 'playlist-create', 'playlist-edit', 'playlist-delete',

            // Astronaut Permissions
            'view-own-playlist',  'edit-own-playlist', 'delete-own-playlist',
            'edit-own-profile',

            // Manager Permissions
            'edit-public-playlist', 'delete-public-playlist', 'view-public-playlist',
            'delete-astronaut'

        ];

        foreach($seedPermissions as $permission){
            Permission::create([ 'name' => $permission]);
        }

    }
}
