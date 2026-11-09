<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        Buku::create([
            'title' => 'Matematika SMA Kelas XI',
            'author' => 'Tim Penulis Kemdikbud',
            'category' => 'Pelajaran',
            'stock' => 15,
        ]);

        Buku::create([
            'title' => 'Laskar Pelangi',
            'author' => 'Andrea Hirata',
            'category' => 'Novel',
            'stock' => 5,
        ]);

        Buku::create([
            'title' => 'Bumi Manusia',
            'author' => 'Pramoedya Ananta Toer',
            'category' => 'Fiksi',
            'stock' => 3,
        ]);

        Buku::create([
            'title' => 'Fisika Kuantum Dasar',
            'author' => 'Prof. Supriyadi',
            'category' => 'Sains',
            'stock' => 8,
        ]);
    }
}