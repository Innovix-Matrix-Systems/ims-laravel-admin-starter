<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    private $guard = "web";

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            //role
            [
                'name' => 'role.view',
                'guard_name' => $this->guard,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'role.view.all',
                'guard_name' => $this->guard,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'role.create',
                'guard_name' => $this->guard,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'role.update',
                'guard_name' => $this->guard,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'role.delete',
                'guard_name' => $this->guard,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //user
            [
                'name' => 'user.view',
                'guard_name' => $this->guard,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'user.view.all',
                'guard_name' => $this->guard,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'user.create',
                'guard_name' => $this->guard,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'user.update',
                'guard_name' => $this->guard,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'user.delete',
                'guard_name' => $this->guard,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::insert($permissions);
    }
}
