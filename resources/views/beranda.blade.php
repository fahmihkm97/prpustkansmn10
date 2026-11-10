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

<!-- Hero Section (Responsif Desktop & Mobile) -->
<section class="hero" style="position:relative; display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:24px; padding:32px 24px; overflow:hidden;">
    <div class="orb"></div>
    
    <!-- Kolom Teks Kiri -->
    <div style="position:relative; z-index:2; flex:1 1 300px; max-width:580px;">
        <span class="pill" style="margin-bottom:12px; display:inline-block;">Perpustakaan digital sekolah</span>
        
        <h1 class="s" style="font-size: clamp(20px, 4vw, 30px); font-weight:800; line-height:1.3; margin-bottom:18px; word-break:break-word;">
            Temukan buku favoritmu, pinjam dalam sekejap.
        </h1>
        
        <div style="display:flex; gap:10px; width:100%; flex-wrap:wrap;">
            <input class="input" id="q" style="flex:1; min-width:180px; border-color:#fff" placeholder="Cari judul, penulis, atau kategori">
            <a class="btn" href="#koleksi" style="white-space:nowrap;">Cari buku</a>
        </div>
    </div>

    <!-- Hiasan Sampul Buku Melayang di Sisi Kanan (Responsif) -->
    <div style="position:relative; z-index:2; display:flex; gap:10px; align-items:center; justify-content:center; flex:0 1 auto; margin:0 auto;">
        @if ($hero->isNotEmpty())
            @foreach ($hero as $i => $b)
                @php $rotate = ['rotate(-6deg)', 'translateY(-10px)', 'rotate(6deg)'][$i % 3]; @endphp
                <div style="transform:{{ $rotate }}; background:#fff; padding:4px; border-radius:6px; box-shadow:0 6px 16px rgba(0,0,0,0.15); max-width:85px;">
                    @include('partials.sampul-buku', ['title' => $b->title])
                </div>
            @endforeach
        @else
            <!-- Fallback Mockup Kartu -->
            <div style="transform:rotate(-6deg); background:#fff; padding:6px 10px; border-radius:6px; width:65px; height:90px; display:flex; align-items:center; justify-content:center; text-align:center; font-size:10px; font-weight:bold; color:#1e40af; box-shadow:0 6px 16px rgba(0,0,0,0.15);">📖 Novel</div>
            <div style="transform:translateY(-10px); background:#fff; padding:6px 10px; border-radius:6px; width:70px; height:95px; display:flex; align-items:center; justify-content:center; text-align:center; font-size:10px; font-weight:bold; color:#1e40af; box-shadow:0 6px 16px rgba(0,0,0,0.15);">📚 Sains</div>
            <div style="transform:rotate(6deg); background:#fff; padding:6px 10px; border-radius:6px; width:65px; height:90px; display:flex; align-items:center; justify-content:center; text-align:center; font-size:10px; font-weight:bold; color:#1e40af; box-shadow:0 6px 16px rgba(0,0,0,0.15);">📕 Sejarah</div>
        @endif
    </div>
</section>

<!-- Filter Kategori Chip -->
@if ($categories->isNotEmpty())
    <div class="px" style="display:flex; gap:10px; padding-top:24px; padding-bottom:8px; flex-wrap:wrap">
        @foreach ($categories as $i => $cat)
            <button type="button" class="chip c{{ $i % 5 }}" data-cat="{{ $cat }}">{{ $cat }}</button>
        @endforeach
    </div>
@endif

<!-- Daftar Koleksi Buku -->
<section id="koleksi" class="px" style="padding-top:20px; padding-bottom:44px">
    <div style="display:flex; justify-content:space-between; align-items:baseline; margin-bottom:18px; flex-wrap:wrap; gap:8px">
        <h2 class="s" style="font-size:26px">Koleksi buku</h2>
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