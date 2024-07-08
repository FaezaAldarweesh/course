<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $AdminUser = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => ["Admin"],
        ]);

        $roleAdmin = Role::create(['name' => 'Admin']);
        $permissionsAdmin = Permission::whereBetween('id', [1, 34])->pluck('id')->all();
        $roleAdmin->syncPermissions($permissionsAdmin);


        $roleStudent = Role::create(['name' => 'Student']);
        $permissionsStudent = Permission::whereBetween('id', [35, 38])->pluck('id')->all();
        $roleStudent->syncPermissions($permissionsStudent);

        $AdminUser->assignRole($roleAdmin->id);
    }
}
