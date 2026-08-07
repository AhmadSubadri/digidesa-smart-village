<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $roles = [
            'super_admin' => 'Super Administrator',
            'admin' => 'Administrator',
            'operator' => 'Operator',
            'sekretaris' => 'Sekretaris',
            'lurah' => 'Lurah',
            'kasi' => 'Kepala Seksi',
        ];

        foreach ($roles as $name => $label) {
            Role::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        // Create super admin user
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@condongcatur.go.id'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Admin@1234'),
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole('super_admin');

        // Create lurah user
        $lurah = User::firstOrCreate(
            ['email' => 'lurah@condongcatur.go.id'],
            [
                'name' => 'Lurah Condongcatur',
                'password' => Hash::make('Lurah@1234'),
                'email_verified_at' => now(),
            ]
        );
        $lurah->assignRole('lurah');

        // Create operator user
        $operator = User::firstOrCreate(
            ['email' => 'operator@condongcatur.go.id'],
            [
                'name' => 'Operator Desa',
                'password' => Hash::make('Operator@1234'),
                'email_verified_at' => now(),
            ]
        );
        $operator->assignRole('operator');
    }
}
