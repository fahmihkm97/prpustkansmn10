<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;

class PengembalianSiswaController extends Controller
{
    public function index()
    {
        $returns = Peminjaman::with('buku')
            ->where('user_id', auth()->id())
            ->where('status', 'DIKEMBALIKAN')
            ->latest()
            ->get();

        return view('siswa.riwayat-pengembalian', compact('returns'));
    }
}