<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;

class KatalogController extends Controller
{
    // Beranda Publik (Tanpa login)
    public function publicIndex()
    {
        $books = Buku::latest()->get();
        return view('beranda', compact('books'));
    }

    // Katalog Area Siswa (Setelah Login)
    public function index()
    {
        $books = Buku::latest()->get();
        return view('siswa.katalog-buku', compact('books'));
    }
}