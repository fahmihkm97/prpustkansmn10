<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Buku::count();
        $activeLoans = Peminjaman::where('status', 'DIPINJAM')->count();
        $overdueLoans = Peminjaman::where('status', 'TERLAMBAT')->count();
        $returnedLoans = Peminjaman::where('status', 'DIKEMBALIKAN')->count();

        return view('admin.dashboard', compact(
            'totalBooks',
            'activeLoans',
            'overdueLoans',
            'returnedLoans'
        ));
    }
}