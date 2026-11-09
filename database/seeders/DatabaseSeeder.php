<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'Petugas Perpustakaan',
            'email' => 'admin@sman10.sch.id',
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);

        // 2. Buat Akun Siswa
        User::create([
            'name' => 'Fahmi Hakim',
            'email' => 'siswa@sman10.sch.id',
            'nisn' => '12345678',
            'role' => 'siswa',
            'password' => Hash::make('password123'),
        ]);

        // 3. Memanggil BookSeeder untuk isi data buku
        $this->call(BookSeeder::class);
    }
}