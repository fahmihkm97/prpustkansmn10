<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanAdminController extends Controller
{
    public function showProsesForm()
    {
        return view('admin.proses-peminjaman');
    }

    // Mengambil Detail Peminjaman Berdasarkan Kode (TRX)
    public function getDetail($trx_code)
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->where('trx_code', $trx_code)->first();

        if (!$peminjaman) {
            return response()->json(['success' => false, 'message' => 'Kode peminjaman / pengembalian tidak ditemukan!'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'trx_code' => $peminjaman->trx_code,
                'user_name' => $peminjaman->user ? $peminjaman->user->name : 'Siswa SMAN 10',
                'book_title' => $peminjaman->buku ? $peminjaman->buku->title : '-',
                'status' => $peminjaman->status,
                'due_date' => $peminjaman->due_date ? date('d M Y', strtotime($peminjaman->due_date)) : 'Belum Diambil',
            ]
        ]);
    }

    public function indexAktif()
    {
        $borrowings = Peminjaman::with(['user', 'buku'])
            ->whereIn('status', ['PENDING', 'DIPINJAM'])
            ->latest()
            ->get();

        return view('admin.peminjaman-aktif', compact('borrowings'));
    }

    public function approvePickup(Request $request)
    {
        $request->validate(['trx_code' => 'required']);

        $peminjaman = Peminjaman::where('trx_code', $request->trx_code)->first();

        if (!$peminjaman) {
            return response()->json(['success' => false, 'message' => 'Kode peminjaman tidak ditemukan!'], 404);
        }

        if ($peminjaman->status !== 'PENDING') {
            return response()->json(['success' => false, 'message' => 'Status peminjaman ini bukan PENDING.'], 400);
        }

        // Pengecekan stok buku
        if ($peminjaman->buku) {
            if ($peminjaman->buku->stock <= 0) {
                return response()->json(['success' => false, 'message' => 'Stok buku ini sedang habis.'], 400);
            }
            $peminjaman->buku->decrement('stock');
        }

        // Tanggal batas pengembalian dapat diatur dari request atau default 7 hari
        $dueDate = $request->due_date ? $request->due_date : now()->addDays(7);

        $peminjaman->update([
            'status' => 'DIPINJAM',
            'borrowed_at' => now(),
            'due_date' => $dueDate,
        ]);

        return response()->json(['success' => true, 'message' => 'Buku berhasil diserahkan ke siswa. Status berubah ke DIPINJAM.']);
    }
}