<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;

class SiswaTerlambatController extends Controller
{
    public function index()
    {
        $overdueLoans = Peminjaman::with(['user', 'buku'])
            ->where('status', 'TERLAMBAT')
            ->orWhere(function ($query) {
                $query->where('status', 'DIPINJAM')
                      ->where('due_date', '<', now());
            })
            ->latest()
            ->get();

        return view('admin.siswa-terlambat', compact('overdueLoans'));
    }
}