<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // BAPB Permissions
            'bapb.view',
            'bapb.create',
            'bapb.edit',
            'bapb.delete',
            'bapb.approve',
            'bapb.reject',
            
            // BAPP Permissions
            'bapp.view',
            'bapp.create',
            'bapp.edit',
            'bapp.delete',
            
            // User Management
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',
            
            // Report Permissions
            'report.view',
            'report.generate',
            
            // Dashboard
            'dashboard.view',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo(Permission::all());

        $direksiRole = Role::create(['name' => 'direksi', 'guard_name' => 'web']);
        $direksiRole->givePermissionTo([
            'bapb.view',
            'bapb.approve',
            'bapb.reject',
            'dashboard.view',
            'report.view',
        ]);

        $vendorRole = Role::create(['name' => 'vendor', 'guard_name' => 'web']);
        $vendorRole->givePermissionTo([
            'bapb.create',
            'bapb.view',
            'bapp.create',
            'bapp.view',
            'dashboard.view',
        ]);

        $picGudangRole = Role::create(['name' => 'pic-gudang', 'guard_name' => 'web']);
        $picGudangRole->givePermissionTo([
            'bapb.view',
            'bapp.view',
            'dashboard.view',
        ]);

        echo "✅ Roles created: admin, direksi, vendor, pic-gudang\n";
        echo "✅ Permissions created: " . count($permissions) . " permissions\n";
    }
}