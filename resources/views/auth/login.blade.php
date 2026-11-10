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
                <div style="position: relative;">
                    <input class="input" type="password" id="login-password" name="password" required placeholder="••••••••" style="padding-right: 40px;">
                    <button type="button" onclick="togglePasswordVisibility('login-password', this)" aria-label="Toggle kata sandi" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--muted); padding: 4px; display: flex; align-items: center;">
                        <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg class="eye-off-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                    </button>
                </div>
            </div>

            <button class="btn btn-blue btn-block" type="submit">Masuk</button>

            <div class="muted" style="font-size: 14px; text-align: center;">
                Belum punya akun? <a class="link" href="{{ route('register') }}">Daftar sebagai siswa</a>
            </div>

            <a href="{{ route('beranda') }}" class="btn btn-ghost btn-block" style="text-align: center; text-decoration: none;">Kembali ke Beranda</a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        const eye = btn.querySelector('.eye-icon');
        const eyeOff = btn.querySelector('.eye-off-icon');

        if (input.type === 'password') {
            input.type = 'text';
            eye.style.display = 'none';
            eyeOff.style.display = 'block';
        } else {
            input.type = 'password';
            eye.style.display = 'block';
            eyeOff.style.display = 'none';
        }
    }
</script>
@endpush