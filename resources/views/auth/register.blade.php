@extends('layouts.tamu')
@section('title', 'Daftar Siswa — Perpustakaan SMAN 10 Semarang')

@section('content')
<div class="auth wide">
    <div class="art green">
        <div class="o1"></div><div class="o2"></div>
        <a href="{{ route('beranda') }}" class="s" style="font-size:22px; text-decoration:none; color:inherit;">
            Perpustakaan SMAN 10 Semarang
        </a>
        <div>
            <h1 class="s" style="font-size:48px; line-height:1.15; margin-top:16px;">Satu akun untuk semua buku.</h1>
        </div>
    </div>

    <div class="panel">
        <form method="POST" action="{{ route('register') }}" style="max-width:460px; display:flex; flex-direction:column; gap:16px;">
            @csrf
            <h2 class="s">Daftar siswa</h2>

            @include('partials.flash')

            <div>
                <label class="label" for="name">Nama lengkap</label>
                <input class="input" id="name" name="name" value="{{ old('name') }}" placeholder="Nama sesuai kartu pelajar" required autofocus>
            </div>
            <div>
                <label class="label" for="nisn">NISN</label>
                <input class="input" id="nisn" name="nisn" value="{{ old('nisn') }}" inputmode="numeric" placeholder="10 digit NISN" required>
            </div>
            <div>
                <label class="label" for="email">Email</label>
                <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
            </div>
            <div class="form-grid" style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                <div>
                    <label class="label" for="password">Kata sandi</label>
                    <div style="position: relative;">
                        <input class="input" id="password" type="password" name="password" placeholder="••••••••" minlength="6" required style="padding-right: 40px;">
                        <button type="button" onclick="togglePasswordVisibility('password', this)" aria-label="Toggle kata sandi" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--muted); padding: 4px; display: flex; align-items: center;">
                            <svg class="eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="eye-off-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="label" for="password_confirmation">Konfirmasi</label>
                    <div style="position: relative;">
                        <input class="input" id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••" required style="padding-right: 40px;">
                        <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" aria-label="Toggle konfirmasi kata sandi" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--muted); padding: 4px; display: flex; align-items: center;">
                            <svg class="eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="eye-off-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            <button class="btn btn-blue btn-block" type="submit">Daftar akun</button>
            <div class="muted" style="font-size:14px; text-align:center;">
                Sudah punya akun? <a class="link" href="{{ route('login') }}">Masuk di sini</a>
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