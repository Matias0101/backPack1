<?php

namespace Database\Seeders;

use Backpack\PermissionManager\app\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Verificar y crear permisos solo si no existen
        if (!Permission::where('name', 'manage categories')->exists()) {
            Permission::create(['name' => 'manage categories', 'guard_name' => 'web']);
        }

        if (!Permission::where('name', 'manage products')->exists()) {
            Permission::create(['name' => 'manage products', 'guard_name' => 'web']);
        }

        if (!Permission::where('name', 'manage users')->exists()) {
            Permission::create(['name' => 'manage users', 'guard_name' => 'web']);
        }

        if (!Permission::where('name', 'manage tags')->exists()) {
            Permission::create(['name' => 'manage tags', 'guard_name' => 'web']);
        }

        // Crear el rol admin si no existe
        $roleAdmin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // Asignar todos los permisos al rol admin
        $roleAdmin->givePermissionTo(['manage categories', 'manage products', 'manage users', 'manage tags']);
    

        // Si quieres asignar los permisos a un rol, aquí puedes agregar el código.
        // $roleAdmin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        // $roleAdmin->givePermissionTo(['manage categories', 'manage products', 'manage users', 'manage tags']);
        // 
        // $user = \App\Models\User::where('email', 'martin@gmail.com')->first();
        //$user->assignRole('admin');

    }
}
