@extends('layouts.siswa')
@section('title', 'Katalog Buku')

@section('content')
@php $categories = $books->pluck('category')->filter()->unique()->sort()->values(); @endphp

<h1 class="s" style="font-size:36px;margin-bottom:20px">Katalog buku</h1>
<input class="input" id="q" style="max-width:640px;margin-bottom:28px" placeholder="Cari judul, penulis, atau kategori">

<div class="cat-layout" style="display:grid;grid-template-columns:220px 1fr;gap:32px">
    <aside class="cd" style="padding:22px;align-self:start">
        <div class="s" style="font-size:18px;margin-bottom:8px">Kategori</div>
        @forelse ($categories as $cat)
            <label class="cat-box"><input type="checkbox" class="f-cat" value="{{ $cat }}">{{ $cat }}</label>
        @empty
            <div class="ba">Belum ada kategori</div>
        @endforelse

        <div class="s" style="font-size:18px;margin:20px 0 8px">Ketersediaan</div>
        <label class="cat-box"><input type="checkbox" id="f-avail">Hanya yang tersedia</label>
    </aside>

    <div>
        <div style="display:flex;justify-content:space-between;margin-bottom:18px;font-size:14px">
            <span class="ba" id="count">Menampilkan {{ $books->count() }} buku</span>
        </div>
        <div class="grid-books">
            @foreach ($books as $book)
                @include('partials.kartu-buku', ['book' => $book, 'mode' => 'pinjam'])
            @endforeach
        </div>
        <div id="no-result" class="empty" style="{{ $books->isEmpty() ? '' : 'display:none' }}">Tidak ada buku yang cocok.</div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/catalog.js') }}"></script>
@endpush