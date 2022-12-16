<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    public array $permissionNames = [
        'view users list', 'view users', 'create users', 'update users', 'delete users'
    ];

    public array $permissionNamesByRole = [
        'admin' => [
            'view users list', 'view users', 'create users', 'update users', 'delete users'
        ]
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach ($this->permissionNames as $permName) {
            Permission::create(['name' => $permName]);
        }

        foreach ($this->permissionNamesByRole as $roleName => $permissionNames) {
            $role = Role::create(['name' => $roleName]);

            foreach ($permissionNames as $permissionName) {
                $role->givePermissionTo($permissionName);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        foreach ($this->permissionNamesByRole as $roleName => $permissionNames) {

            $role = Role::findByName($roleName);

            foreach ($permissionNames as $permName)
                $role->revokePermissionTo($permName);

            $role->delete();
        }

        foreach ($this->permissionNames as $permName) {
            $permission = Permission::findByName($permName);
            $permission->delete();
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
};
