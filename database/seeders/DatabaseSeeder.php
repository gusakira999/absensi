<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        
        // Example dosen and mahasiswa accounts
        User::firstOrCreate([
            'email' => 'dosenbambang@example.com',
        ], [
            'name' => 'Pak Bambang',
            'password' => Hash::make('password'),
            'role' => 'dosen',
        ]);

        User::firstOrCreate([
            'email' => 'nurachmadhidayat@example.com',
        ], [
            'name' => 'Nur Achmad Hidayat',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'nim' => '0000001',
        ]);
    }
}
