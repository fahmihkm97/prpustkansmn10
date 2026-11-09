@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="page-head">
    <div>
        <h1 class="s" style="font-size:38px;margin-bottom:6px">Selamat datang, {{ \Illuminate\Support\Str::of(auth()->user()->name)->before(' ') }}</h1>
        <div class="muted">Ringkasan aktivitas perpustakaan hari ini</div>
    </div>
    <a class="btn" href="{{ route('admin.proses-peminjaman') }}">Proses Peminjaman</a>
</div>

<div class="stats">
    <div class="stat" style="background:var(--info-bg);color:var(--info-fg)">
        <div class="t">Total koleksi</div><div class="n s">{{ $totalBooks }}</div>
    </div>
    <div class="stat" style="background:var(--ok-bg);color:var(--ok-fg)">
        <div class="t">Pinjaman aktif</div><div class="n s">{{ $activeLoans }}</div>
    </div>
    <div class="stat" style="background:var(--no-bg);color:var(--no-fg)">
        <div class="t">Siswa terlambat</div><div class="n s">{{ $overdueLoans }}</div>
    </div>
    <div class="stat" style="background:var(--wn-bg);color:var(--wn-fg)">
        <div class="t">Sudah dikembalikan</div><div class="n s">{{ $returnedLoans }}</div>
    </div>
</div>

@isset($recentLoans)
    <div class="cd" style="overflow:hidden">
        <div class="s" style="font-size:20px;padding:20px 22px">Transaksi terbaru</div>
        <div class="tbl-wrap" style="border-radius:0">
            <div class="tbl" style="--cols:1fr 1.4fr 1fr 1fr">
                <div class="tr th"><span>Kode</span><span>Buku</span><span>Batas kembali</span><span>Status</span></div>
                @forelse ($recentLoans as $l)
                    @include('partials.baris-pinjaman', ['l' => $l])
                @empty
                    <div class="empty">Belum ada transaksi.</div>
                @endforelse 
            </div>
        </div>
    </div>
@endisset
@endsection