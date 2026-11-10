<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visitor; // Sesuaikan dengan nama Model Pengunjung Anda (misal: Pengunjung)
use Illuminate\Http\Request;

class PengunjungController extends Controller
{
    public function index()
    {
        // Pastikan view yang dipanggil adalah 'admin.daftar-pengunjung'
        $visitors = class_exists(Visitor::class) ? Visitor::latest()->get() : collect();
        
        return view('admin.daftar-pengunjung', compact('visitors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if (class_exists(Visitor::class)) {
            Visitor::create([
                'name'     => $request->name,
                'identity' => $request->identity,
                'purpose'  => $request->purpose ?? 'Membaca / Meminjam Buku',
            ]);
        }

        return back()->with('success', 'Data pengunjung berhasil dicatat.');
    }

    public function destroy($id)
    {
        if (class_exists(Visitor::class)) {
            $visitor = Visitor::findOrFail($id);
            $visitor->delete();
        }

        return back()->with('success', 'Data kunjungan berhasil dihapus.');
    }
}