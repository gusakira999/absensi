<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //buat 1 admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        //buat 1 Dosen
        User::create([
            'name' => 'Dosen',
            'email' => 'dosen@test.com',
            'password' => Hash::make('password'),
            'role' => 'dosen',
        ]);

        //buat 1 Mahasiswa
        User::create([
            'name' => 'Mahasiswa',
            'email' => 'mh@test.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);
    }
}
