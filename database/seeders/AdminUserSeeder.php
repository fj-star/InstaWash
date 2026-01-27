<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Fazril',
            'email' => 'admin@example.com',
            'no_hp' => '023920139',
            'alamat'=>'cianjur',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);
        User::create([
        'name' => 'Owner',
        'email' => 'owner@laundry.com',
        'no_hp' => '023920138',
        'alamat'=>'cianjur',
        'password' => Hash::make('password'),
        'role' => 'owner'
    ]);

    User::create([
        'name' => 'Karyawan',
        'email' => 'karyawan@laundry.com',
        'no_hp' => '023920137',
        'alamat'=>'cianjur',
        'password' => Hash::make('password'),
        'role' => 'karyawan'
    ]);
    }

}
