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
            ->whereIn('status', ['PENDING', 'DIPINJAM', 'TERLAMBAT'])
            ->latest()
            ->get();

        $viewName = view()->exists('siswa.peminjaman-aktif') ? 'siswa.peminjaman-aktif' : 'siswa.peminjaman';
        return view($viewName, compact('borrowings'));
    }

    // Alias handler untuk rute POST /siswa/pinjam/{id}
    public function pinjam(Request $request, $id = null)
    {
        return $this->storeRequest($request, $id);
    }

    public function storeRequest(Request $request, $id = null)
    {
        $bukuId = $id ?? $request->buku_id ?? $request->book_id;

        if (!$bukuId) {
            return back()->with('error', 'Buku tidak ditemukan.');
        }

        $buku = Buku::findOrFail($bukuId);

        if ($buku->stock <= 0) {
            return back()->with('error', 'Stok buku sedang habis.');
        }

        // PERBAIKAN: Menggunakan nama kolom 'book_id' (bukan 'buku_id')
        $existing = Peminjaman::where('user_id', auth()->id())
            ->where('book_id', $buku->id)
            ->whereIn('status', ['PENDING', 'DIPINJAM', 'TERLAMBAT'])
            ->first();

        if ($existing) {
            return back()->with('warning', 'Anda masih memiliki peminjaman aktif untuk buku ini.');
        }

        // Generate Kode Transaksi unik
        $trxCode = 'TRX-' . strtoupper(Str::random(8));

        Peminjaman::create([
            'trx_code' => $trxCode,
            'user_id'  => auth()->id(),
            'book_id'  => $buku->id, // PERBAIKAN: book_id
            'status'   => 'PENDING',
        ]);

        return redirect()->route('siswa.peminjaman')->with('success', 'Berhasil memesan buku! Kode Transaksi Anda: ' . $trxCode);
    }
}