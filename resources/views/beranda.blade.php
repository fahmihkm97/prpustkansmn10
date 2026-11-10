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
<section class="hero" style="position:relative; display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:24px; padding:40px 28px; overflow:hidden;">
    <div class="orb"></div>
    
    <!-- Kolom Teks Kiri -->
    <div style="position:relative; z-index:2; flex:1 1 320px; max-width:560px;">
        <span class="pill" style="margin-bottom:14px; display:inline-block;">Perpustakaan digital sekolah</span>
        
        <h1 class="s" style="font-size: clamp(22px, 4vw, 32px); font-weight:800; line-height:1.25; margin-bottom:20px; word-break:break-word;">
            Temukan buku favoritmu, pinjam dalam sekejap.
        </h1>
        
        <div style="display:flex; gap:10px; width:100%; flex-wrap:wrap;">
            <input class="input" id="q" style="flex:1; min-width:180px; border-color:#fff" placeholder="Cari judul, penulis, atau kategori">
            <a class="btn" href="#koleksi" style="white-space:nowrap;">Cari buku</a>
        </div>
    </div>

    <!-- Hiasan Kartu Buku Melayang di Sisi Kanan (Ukuran Lebih Besar & Elemen Kartu Lengkap) -->
    <div style="position:relative; z-index:2; display:flex; gap:16px; align-items:center; justify-content:center; flex:0 1 auto; margin:0 auto;">
        @if ($hero->isNotEmpty())
            @foreach ($hero as $i => $b)
                @php 
                    $rotate = ['rotate(-6deg) translateY(6deg)', 'translateY(-14px) scale(1.05)', 'rotate(6deg) translateY(6deg)'][$i % 3]; 
                @endphp
                <div style="transform:{{ $rotate }}; background:#ffffff; padding:8px; border-radius:12px; box-shadow:0 12px 28px rgba(15,27,61,0.22); width:125px; transition:all 0.3s ease;">
                    <!-- Cover Sampul Buku -->
                    <div style="border-radius:6px; overflow:hidden;">
                        @include('partials.sampul-buku', ['title' => $b->title, 'cover_image' => $b->cover_image])
                    </div>
                    <!-- Detail Informasi Kartu Buku -->
                    <div style="margin-top:8px; text-align:left;">
                        <div class="s" style="font-size:12px; font-weight:700; color:var(--ink); line-height:1.25; height:30px; overflow:hidden; text-overflow:ellipsis; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;">
                            {{ $b->title }}
                        </div>
                        <div style="font-size:10px; color:var(--muted); margin-top:3px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            {{ $b->author }}
                        </div>
                        <div style="margin-top:6px;">
                            <span class="badge {{ $b->stock > 0 ? 'ok' : 'no' }}" style="font-size:9px; padding:2px 6px;">
                                {{ $b->stock > 0 ? 'Tersedia' : 'Habis' }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <!-- Fallback Mockup Kartu Utuh Jika Database Kosong -->
            <div style="transform:rotate(-6deg) translateY(6deg); background:#ffffff; padding:8px; border-radius:12px; box-shadow:0 12px 28px rgba(15,27,61,0.22); width:125px;">
                <div class="bk" style="background:#10B981; height:120px; border-radius:6px; padding:6px; font-size:10px;">📖</div>
                <div style="margin-top:8px; text-align:left;">
                    <div class="s" style="font-size:12px; font-weight:700; color:var(--ink);">Laskar Pelangi</div>
                    <div style="font-size:10px; color:var(--muted); margin-top:2px;">Andrea Hirata</div>
                    <span class="badge ok" style="font-size:9px; padding:2px 6px; margin-top:6px; display:inline-block;">Tersedia</span>
                </div>
            </div>

            <div style="transform:translateY(-14px) scale(1.05); background:#ffffff; padding:8px; border-radius:12px; box-shadow:0 12px 28px rgba(15,27,61,0.22); width:125px;">
                <div class="bk" style="background:#1D4ED8; height:120px; border-radius:6px; padding:6px; font-size:10px;">📚</div>
                <div style="margin-top:8px; text-align:left;">
                    <div class="s" style="font-size:12px; font-weight:700; color:var(--ink);">Fisika Modern</div>
                    <div style="font-size:10px; color:var(--muted); margin-top:2px;">Halliday</div>
                    <span class="badge ok" style="font-size:9px; padding:2px 6px; margin-top:6px; display:inline-block;">Tersedia</span>
                </div>
            </div>

            <div style="transform:rotate(6deg) translateY(6deg); background:#ffffff; padding:8px; border-radius:12px; box-shadow:0 12px 28px rgba(15,27,61,0.22); width:125px;">
                <div class="bk" style="background:#FFC93C; color:#0F1B3D; height:120px; border-radius:6px; padding:6px; font-size:10px;">📕</div>
                <div style="margin-top:8px; text-align:left;">
                    <div class="s" style="font-size:12px; font-weight:700; color:var(--ink);">Sejarah Dunia</div>
                    <div style="font-size:10px; color:var(--muted); margin-top:2px;">H.G. Wells</div>
                    <span class="badge ok" style="font-size:9px; padding:2px 6px; margin-top:6px; display:inline-block;">Tersedia</span>
                </div>
            </div>
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