@extends('layouts.tamu')
@section('title', 'Perpustakaan Digital SMAN 10 Semarang')

@section('content')
@php
    $categories = $books->pluck('category')->filter()->unique()->sort()->values();
    $hero = $books->take(3);
@endphp

<!-- Header Beranda Publik -->
<header class="header-guest">
    <a href="{{ route('beranda') }}" class="logo" style="display:flex; align-items:center; gap:12px; text-decoration:none">
        <img src="{{ asset('images/LOGOSMANTEN10.png') }}" alt="Logo SMAN 10 Semarang" style="height:38px; width:auto; object-fit:contain;">
        <div class="s" style="font-size:16px; font-weight:700;">Perpustakaan SMAN 10 Semarang</div>
    </a>
    
    <!-- Menu Navigasi di Tengah -->
    <nav class="guest-nav">
        <a href="#koleksi" class="nav-pill">Koleksi</a>
        <a href="#cara" class="nav-pill">Cara meminjam</a>
    </nav>

    <!-- Tombol Masuk / Akun -->
    <div>
        @auth
            <a class="btn btn-blue btn-sm" href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('siswa.katalog-buku') }}">Buka akun</a>
        @else
            <a class="btn btn-blue btn-sm" href="{{ route('login') }}">Masuk</a>
        @endauth
    </div>
</header>

<!-- Hero Section -->
<section class="hero">
    <div class="orb"></div>
    <div style="position:relative">
        <span class="pill">Perpustakaan digital sekolah</span>
        <h1 class="s">Temukan buku favoritmu, pinjam dalam sekejap.</h1>
        <div style="display:flex;gap:10px;max-width:540px;flex-wrap:wrap">
            <input class="input" id="q" style="flex:1;min-width:200px;border-color:#fff" placeholder="Cari judul, penulis, atau kategori">
            <a class="btn" href="#koleksi">Cari buku</a>
        </div>
    </div>
    @if ($hero->count() === 3)
        <div class="hero-books">
            @foreach ($hero as $i => $b)
                @php $t = ['rotate(-7deg)', 'translateY(-20px)', 'rotate(7deg)'][$i]; @endphp
                <div style="transform:{{ $t }}">@include('partials.sampul-buku', ['title' => $b->title])</div>
            @endforeach
        </div>
    @endif
</section>

<!-- Filter Kategori Chip -->
@if ($categories->isNotEmpty())
    <div class="px" style="display:flex;gap:12px;padding-top:28px;padding-bottom:8px;flex-wrap:wrap">
        @foreach ($categories as $i => $cat)
            <button type="button" class="chip c{{ $i % 5 }}" data-cat="{{ $cat }}">{{ $cat }}</button>
        @endforeach
    </div>
@endif

<!-- Daftar Koleksi Buku -->
<section id="koleksi" class="px" style="padding-top:20px;padding-bottom:44px">
    <div style="display:flex;justify-content:space-between;align-items:baseline;margin-bottom:18px;flex-wrap:wrap;gap:8px">
        <h2 class="s" style="font-size:28px">Koleksi buku</h2>
        <span id="count" class="ba"></span>
    </div>

    <div class="grid-books five">
        @foreach ($books as $book)
            @include('partials.kartu-buku', ['book' => $book, 'mode' => 'login'])
        @endforeach
    </div>
    <div id="no-result" class="empty" style="{{ $books->isEmpty() ? '' : 'display:none' }}">Belum ada buku yang cocok.</div>
</section>

<!-- Panduan Cara Meminjam -->
<section id="cara" class="steps">
    <div class="step"><div class="n">1</div><b>Cari buku</b></div>
    <div class="step"><div class="n">2</div><b>Pesan lewat ponsel</b></div>
    <div class="step"><div class="n">3</div><b>Ambil di perpustakaan</b></div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/catalog.js') }}"></script>
@endpush