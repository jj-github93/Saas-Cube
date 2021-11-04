<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Password1'),
                'created_at' => now(),
            ]
        );
        $role = Role::create(['name' => "Admin"]);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $admin->assignRole([$role->id]);
    }
}
