@extends('layouts.guest')
@section('title', 'Daftar siswa — Perpustakaan SMAN Semarang')

@section('content')
<div class="auth wide">
    <div class="art green">
        <div class="o1"></div><div class="o2"></div>
        <a href="{{ route('beranda') }}" class="s" style="font-size:22px">Perpustakaan SMAN Semarang</a>
        <div>
            <h1 class="s" style="font-size:52px ">Satu akun untuk semua buku.</h1>
        </div>
    </div>

    <div class="panel">
        <form method="POST" action="{{ route('register') }}" style="max-width:460px;gap:16px">
            @csrf
            <h2 class="s">Daftar siswa</h2>

            @include('partials.flash')

            <div>
                <label class="label" for="name">Nama lengkap</label>
                <input class="input" id="name" name="name" value="{{ old('name') }}" placeholder="Nama sesuai kartu pelajar" required>
            </div>
            <div>
                <label class="label" for="nisn">NISN</label>
                <input class="input" id="nisn" name="nisn" value="{{ old('nisn') }}" inputmode="numeric" placeholder="10 digit NISN" required>
            </div>
            <div>
                <label class="label" for="email">Email</label>
                <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
            </div>
            <div class="form-grid" style="gap:12px">
                <div>
                    <label class="label" for="password">Kata sandi</label>
                    <input class="input" id="password" type="password" name="password" placeholder="••••••••" minlength="6" required>
                </div>
                <div>
                    <label class="label" for="password_confirmation">Konfirmasi</label>
                    <input class="input" id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••" required>
                </div>
            </div>
            <button class="btn btn-blue btn-block" type="submit">Daftar akun</button>
            <div class="muted" style="font-size:14px">Sudah punya akun? <a class="link" href="{{ route('login') }}">Masuk di sini</a></div>
        </form>
    </div>
</div>
@endsection
