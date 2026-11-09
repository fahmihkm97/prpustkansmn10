@extends('layouts.guest')
@section('title', 'Halaman tidak ditemukan')

@section('content')
<div class="center-page">
    <div>
        <div class="s" style="font-size:96px;line-height:1;color:var(--blue)">404</div>
        <h1 class="s" style="font-size:32px;margin:8px 0">Halaman tidak ditemukan</h1>
        <p class="muted" style="margin-bottom:24px">Buku yang kamu cari mungkin sudah dipindah rak.</p>
        <a class="btn btn-blue" href="{{ url('/') }}">Kembali ke beranda</a>
    </div>
</div>
@endsection
