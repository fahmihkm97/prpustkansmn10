@extends('layouts.tamu')
@section('title', 'Masuk Akun — Perpustakaan SMAN 10 Semarang')

@section('content')
<div class="auth">
    <div class="art">
        <div class="o1"></div>
        <div class="o2"></div>
        <div style="margin-bottom: 24px;">
            <img src="{{ asset('images/LOGOSMANTEN10.png') }}" alt="Logo SMAN 10 Semarang" style="height: 80px; width: auto; object-fit: contain;">
        </div>
        <h1 class="s">Selamat datang kembali!</h1>
        <p>Masuk untuk meminjam buku dan melihat status peminjaman Anda.</p>
    </div>

    <div class="panel">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <h2 class="s" style="margin-bottom: 4px;">Masuk</h2>
                <div class="muted" style="font-size: 14px;">Gunakan email dan kata sandi terdaftar</div>
            </div>

            <div>
                <label class="label">Email</label>
                <input class="input" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="email@domain.com">
            </div>

            <div>
                <label class="label">Kata Sandi</label>
                <input class="input" type="password" name="password" required placeholder="••••••••">
            </div>

            <button class="btn btn-blue btn-block" type="submit">Masuk</button>

            <div class="muted" style="font-size: 14px; text-align: center;">
                Belum punya akun? <a class="link" href="{{ route('register') }}">Daftar sebagai siswa</a>
            </div>
        </form>
    </div>
</div>
@endsection