<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => 'password123',
                'role' => 'admin',
            ],
            [
                'name' => 'Direksi User',
                'email' => 'direksi@example.com',
                'password' => 'password123',
                'role' => 'direksi',
            ],
            [
                'name' => 'Vendor User',
                'email' => 'vendor@example.com',
                'password' => 'password123',
                'role' => 'vendor',
            ],
            [
                'name' => 'PicGudang User',
                'email' => 'picgudang@example.com',
                'password' => 'password123',
                'role' => 'pic-gudang',
            ],
        ];

        foreach ($users as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                ]
            );

            // pakai syncRoles supaya role selalu sesuai (menghindari duplikasi assign)
            $user->syncRoles([$data['role']]);
        }
    }
}
