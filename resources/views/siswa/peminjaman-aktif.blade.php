@extends('layouts.siswa')
@section('title', 'Pinjaman Saya')

@section('content')
<div style="max-width:760px;margin:0 auto">
    <h1 class="s" style="font-size:32px;margin-bottom:4px">Pinjaman saya</h1>
    <div class="muted" style="margin-bottom:22px">{{ $borrowings->count() }} buku aktif</div>

    @forelse ($borrowings as $b)
        @php
            $map = [
                'PENDING'   => ['wn', 'Menunggu diambil'],
                'DIPINJAM'  => ['ok', 'Dipinjam'],
                'TERLAMBAT' => ['no', 'Terlambat']
            ];
            [$cls, $label] = $map[$b->status] ?? ['info', $b->status];
            $title = $b->buku->title ?? 'Buku';
        @endphp
        
        <!-- Kartu Peminjaman dengan Susunan Flex Vertikal untuk Mencegah Overlap -->
        <div class="cd" style="padding:18px;border-radius:20px;margin-bottom:16px;display:flex;gap:16px;align-items:flex-start;flex-wrap:wrap">
            
            <!-- Cover Buku -->
            <div style="flex:none">
                @include('partials.book-cover', ['title' => $title, 'class' => 'bk-sm'])
            </div>

            <!-- Informasi Buku -->
            <div style="flex:1;min-width:200px">
                <div class="s" style="font-size:18px;margin-bottom:4px">{{ $title }}</div>
                <div class="ba" style="margin-bottom:8px">
                    @if ($b->status === 'PENDING')
                        Tunjukkan Kode Transaksi di bawah ke petugas
                    @else
                        Batas Kembali: <b>{{ $b->due_date ? \Carbon\Carbon::parse($b->due_date)->format('d M Y') : '-' }}</b>
                    @endif
                </div>
                <div>
                    <span class="badge {{ $cls }}">{{ $label }}</span>
                </div>
            </div>
            
            <!-- Kotak Tampilan Kode Transaksi (Tertata Rapi di Samping/Bawah) -->
            <div style="background:var(--head);border:2px dashed var(--line-2);border-radius:14px;padding:12px 16px;text-align:center;width:100%;max-width:220px;margin-left:auto">
                <div class="ba" style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--muted);letter-spacing:.05em">Kode Transaksi</div>
                <div class="s" style="font-size:18px;color:var(--blue);margin-top:2px;letter-spacing:1px">{{ $b->trx_code }}</div>
            </div>

        </div>
    @empty
        <div class="cd empty" style="padding:48px 22px">
            <div class="s" style="font-size:22px;color:var(--ink);margin-bottom:6px">Belum ada pinjaman</div>
            <div style="margin-bottom:18px">Cari buku di katalog, lalu tekan Pinjam.</div>
            <a class="btn btn-blue" href="{{ route('siswa.katalog-buku') }}">Buka katalog</a>
        </div>
    @endforelse
</div>
@endsection