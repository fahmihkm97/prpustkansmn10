<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PengembalianAdminController extends Controller
{
    public function index()
    {
        $returns = Peminjaman::with(['user', 'buku'])
            ->where('status', 'DIKEMBALIKAN')
            ->latest()
            ->get();

        return view('admin.data-pengembalian', compact('returns'));
    }

    public function approveReturn(Request $request)
    {
        $request->validate(['trx_code' => 'required']);

        $peminjaman = Peminjaman::where('trx_code', $request->trx_code)->first();

        if (!$peminjaman) {
            return response()->json(['success' => false, 'message' => 'Kode pengembalian tidak ditemukan!'], 404);
        }

        if (!in_array($peminjaman->status, ['DIPINJAM', 'TERLAMBAT'])) {
            return response()->json(['success' => false, 'message' => 'Buku belum dipinjam atau sudah dikembalikan.'], 400);
        }

        if ($peminjaman->buku) {
            $peminjaman->buku->increment('stock');
        }

        $peminjaman->update([
            'status' => 'DIKEMBALIKAN',
            'returned_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Pengembalian buku berhasil dikonfirmasi. Stok buku bertambah kembali.']);
    }
}