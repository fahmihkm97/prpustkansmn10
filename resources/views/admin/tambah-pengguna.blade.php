@extends('layouts.admin')
@section('title', 'Tambah Pengguna')

@section('content')
<div style="max-width:720px;margin:0 auto">
    <div class="page-head" style="margin-bottom:24px">
        <div>
            <h1 class="s">Tambah pengguna</h1>
            <div class="ba">Daftarkan siswa atau admin baru</div>
        </div>
    </div>

    <div class="cd" style="padding:32px">
        <form method="POST" action="{{ route('admin.user.store') }}">
            @csrf
            
            <div class="form-grid">
                <div class="span2">
                    <label class="label">Peran</label>
                    <div style="display:flex;gap:10px" id="role-selector">
                        <label class="tab on" style="cursor:pointer">
                            <input type="radio" name="role" value="siswa" checked style="display:none"> Siswa
                        </label>
                        <label class="tab" style="cursor:pointer">
                            <input type="radio" name="role" value="admin" style="display:none"> Admin
                        </label>
                    </div>
                </div>

                <div class="span2">
                    <label class="label">Nama lengkap</label>
                    <input class="input" name="name" required placeholder="Nama lengkap" value="{{ old('name') }}">
                </div>

                <div>
                    <label class="label">NISN</label>
                    <input class="input" name="nisn" placeholder="10 digit NISN" value="{{ old('nisn') }}">
                </div>

                <div>
                    <label class="label">Email</label>
                    <input class="input" type="email" name="email" required placeholder="email@domain.com" value="{{ old('email') }}" autocomplete="off">
                </div>

                <div class="span2">
                    <label class="label">Kata sandi awal</label>
                    <input class="input" type="password" name="password" required placeholder="••••••••" autocomplete="new-password">
                </div>

                <div class="span2" style="display:flex;gap:12px;margin-top:8px">
                    <button type="submit" class="btn btn-blue" style="flex:1">Simpan pengguna</button>
                    <a href="{{ url()->previous() }}" class="btn btn-ghost" style="flex:1;text-align:center">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('#role-selector .tab').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('#role-selector .tab').forEach(t => t.classList.remove('on'));
        this.classList.add('on');
        const radio = this.querySelector('input[type="radio"]');
        if (radio) radio.checked = true;
    });
});
</script>
@endpush