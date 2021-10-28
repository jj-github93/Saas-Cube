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
            'user-list', 'user-create', 'user-edit', 'user-delete',
            'role-list', 'role-create', 'role-edit', 'role-delete',
            'permission-list', 'permission-create', 'permission-edit', 'permission-delete',
            'genre-list', 'genre-create', 'genre-edit', 'genre-delete',
            'track-list', 'track-create', 'track-edit', 'track-delete',
            'playlist-list', 'playlist-create', 'playlist-edit', 'playlist-delete',
        ];

        foreach($seedPermissions as $permission){
            Permission::create([ 'name' => $permission]);
        }

    }
}
