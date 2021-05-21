<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        $developerRole = Role::create([
            'name' => 'Developer',
            'guard_name' => 'web',
            'is_default' => 'Y'
        ]);

        $administratorRole = Role::create([
            'name' => 'Ketua Kelompok Tani',
            'guard_name' => 'web',
            'is_default' => 'Y'
        ]);


        $developerRole->givePermissionTo(['read-dashboard', 'read-roles', 'create-roles', 'update-roles', 'delete-roles']);
        $developerRole->givePermissionTo(['read-users', 'create-users', 'update-users', 'delete-users']);
        $developerRole->givePermissionTo(['read-farmer-groups', 'create-farmer-groups', 'update-farmer-groups', 'delete-farmer-groups']);
        $developerRole->givePermissionTo(['read-farmers', 'create-farmers', 'update-farmers', 'delete-farmers']);
        $developerRole->givePermissionTo(['read-devices', 'create-devices', 'update-devices', 'delete-devices']);
        $developerRole->givePermissionTo(['read-mappings']);
        $developerRole->givePermissionTo(['read-settings', 'update-settings']);
        $developerRole->givePermissionTo('read-dashboard');
    }
}
