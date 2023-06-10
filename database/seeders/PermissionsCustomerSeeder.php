<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'users.index',
            'users.store',
            'users.show',
            'users.searchByEmailOrDNI',
            'users.update',
            'users.destroy',
            'users.greet'
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }

        Role::findById(1)->syncPermissions($permissions);
        Role::findById(2)->syncPermissions('users.greet');
    }
}
