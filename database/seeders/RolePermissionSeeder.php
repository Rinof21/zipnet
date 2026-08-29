<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Clear existing permissions & roles cleanly
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create permissions in Indonesian
        $permissions = [
            'lihat dokumen',
            'tambah dokumen',
            'edit dokumen',
            'hapus dokumen',
            'kelola kategori',
            'kelola peran',
            'kelola pengguna',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdminRole->syncPermissions(Permission::all());

        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminRole->syncPermissions([
            'lihat dokumen',
            'tambah dokumen',
            'edit dokumen',
            'kelola kategori',
        ]);

        $userRole = Role::firstOrCreate(['name' => 'Pengguna']);
        $userRole->syncPermissions([
            'lihat dokumen',
        ]);

        // Assign Super Admin role to all existing users
        $users = User::all();
        foreach ($users as $user) {
            $user->assignRole($superAdminRole);
        }
    }
}
