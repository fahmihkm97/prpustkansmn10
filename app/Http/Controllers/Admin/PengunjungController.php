<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;

class PengunjungController extends Controller
{
    public function index()
    {
        $visitors = Visitor::latest()->get();
        return view('admin.daftar-pengunjung', compact('visitors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Visitor::create([
            'name'     => $request->name,
            'identity' => $request->identity,
            'purpose'  => $request->purpose ?: 'Membaca / Meminjam Buku',
        ]);

        return redirect()->route('admin.daftar-pengunjung')->with('success', 'Data pengunjung berhasil dicatat.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $visitor = Visitor::findOrFail($id);
        $visitor->update([
            'name'     => $request->name,
            'identity' => $request->identity,
            'purpose'  => $request->purpose ?: 'Membaca / Meminjam Buku',
        ]);

        return redirect()->route('admin.daftar-pengunjung')->with('success', 'Data pengunjung berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $visitor = Visitor::findOrFail($id);
        $visitor->delete();

        return redirect()->route('admin.daftar-pengunjung')->with('success', 'Data kunjungan berhasil dihapus.');
    }
}