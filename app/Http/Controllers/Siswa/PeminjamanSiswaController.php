<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PeminjamanSiswaController extends Controller
{
    public function index()
    {
        $borrowings = Peminjaman::with('buku')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        // Diperbaiki: Menggunakan nama view baru 'siswa.peminjaman-aktif'
        return view('siswa.peminjaman-aktif', compact('borrowings'));
    }

    // Diperbaiki: Menerima parameter $id dari URL maupun input buku_id dari Form Request
    public function storeRequest(Request $request, $id = null)
    {
        $bukuId = $id ?? $request->buku_id;

        if (!$bukuId) {
            return back()->with('error', 'Buku tidak ditemukan.');
        }

        $buku = Buku::findOrFail($bukuId);

        if ($buku->stock <= 0) {
            return back()->with('error', 'Stok buku sedang habis.');
        }

        // Cek jika siswa masih memiliki transaksi PENDING atau DIPINJAM untuk buku yang sama
        $existing = Peminjaman::where('user_id', auth()->id())
            ->where('buku_id', $buku->id)
            ->whereIn('status', ['PENDING', 'DIPINJAM'])
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda masih memiliki peminjaman aktif untuk buku ini.');
        }

        // Generate Kode Transaksi dengan format BOOK-
        $trxCode = 'BOOK-' . strtoupper(Str::random(6));

        Peminjaman::create([
            'trx_code' => $trxCode,
            'user_id'  => auth()->id(),
            'buku_id'  => $buku->id,
            'status'   => 'PENDING',
        ]);

        return back()->with('success', 'Berhasil melakukan pemesanan buku. Kode Transaksi Anda: ' . $trxCode);
    }
}