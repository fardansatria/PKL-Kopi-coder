<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat peran
        $adminRole = Role::create(['name' => 'admin']);
        $pelangganRole = Role::create(['name' => 'pelanggan']);

        // Buat izin
        $editPermission = Permission::create(['name' => 'edit articles']);
        $viewPermission = Permission::create(['name' => 'view articles']);

        // Assign izin ke peran
        $adminRole->givePermissionTo('edit articles');
        $adminRole->givePermissionTo('view articles');
        $pelangganRole->givePermissionTo('view articles');

        // Assign peran ke pengguna
        $user = User::find(1); // Ganti dengan ID pengguna yang ingin Anda assign
        $user->assignRole('admin');
    }
}
