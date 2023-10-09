<?php

namespace Database\Seeders;

use App\Http\Traits\UserTrait;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    use UserTrait;
    private $guard = "web";
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $role = Role::create([
            'guard_name' => $this->guard,
            'name' => $this->SUPER_ADMIN
        ]);

        $role->givePermissionTo(Permission::all());

        Role::create([
            'guard_name' => $this->guard,
            'name' => $this->ADMIN
        ]);

        Role::create([
            'guard_name' => $this->guard,
            'name' => $this->USER
        ]);
    }
}
