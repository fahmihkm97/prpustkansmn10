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

        $existing = Peminjaman::where('user_id', auth()->id())
            ->where('book_id', $buku->id)
            ->whereIn('status', ['PENDING', 'DIPINJAM', 'TERLAMBAT'])
            ->first();

        if ($existing) {
            return back()->with('warning', 'Anda masih memiliki peminjaman aktif untuk buku ini.');
        }

        // Diubah: Format kode menjadi BOOK- dikuti 4 karakter acak (contoh: BOOK-1T27)
        $trxCode = 'BOOK-' . strtoupper(Str::random(4));

        Peminjaman::create([
            'trx_code' => $trxCode,
            'user_id'  => auth()->id(),
            'book_id'  => $buku->id,
            'status'   => 'PENDING',
        ]);

        return redirect()->route('siswa.peminjaman')->with('success', 'Berhasil memesan buku! Kode Anda: ' . $trxCode);
    }

    public function riwayat()
    {
        $returns = Peminjaman::with('buku')
            ->where('user_id', auth()->id())
            ->where('status', 'DIKEMBALIKAN')
            ->latest()
            ->get();

        return view('siswa.riwayat-pengembalian', compact('returns'));
    }
}