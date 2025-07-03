<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        Permission::create(['name' => 'tambah-user']);
        Permission::create(['name' => 'lihat-pendaftaran']);
        Permission::create(['name' => 'tambah-jasa']);
        Permission::create(['name' => 'edit-jasa']);
        Permission::create(['name' => 'delete-jasa']);
        Permission::create(['name' => 'delete-ulasan']);
        Permission::create(['name' => 'lihat-jasa']); // Added this permission
        
        Permission::create(['name' => 'daftar-jasa']);
        Permission::create(['name' => 'kirim-ulasan']);
        Permission::create(['name' => 'kirim-rating']);
        Permission::create(['name' => 'kirim-chat']);

        // Create Roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        // Assign Permissions to Admin Role
        $roleAdmin = Role::findByName('admin');
        $roleAdmin->givePermissionTo([
            'tambah-user',
            'tambah-jasa',
            'lihat-pendaftaran',
            'edit-jasa',
            'delete-jasa',
            'delete-ulasan'
        ]);

        // Assign Permissions to User Role
        $roleUser = Role::findByName('user');
        $roleUser->givePermissionTo([
            'lihat-jasa',
            'daftar-jasa',
            'kirim-ulasan',
            'kirim-rating',
            'kirim-chat'
        ]);
    }
}