@extends('layouts.admin')
@section('title', 'Kelola User')

@section('content')
<div class="page-head">
    <h1 class="s">Pengguna</h1>
    <a class="btn" href="{{ route('admin.tambah-user') }}">+ Tambah pengguna</a>
</div>

<div style="display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap;align-items:center">
    <input class="input" id="q" style="max-width:380px" placeholder="Cari nama, email, atau NISN">
    
    <!-- Custom Dropdown Filter Peran -->
    <div class="custom-select-wrap" style="position:relative;width:180px">
        <input type="hidden" id="f-role" value="">
        <button type="button" class="input custom-select-btn" id="custom-role-btn" style="display:flex;align-items:center;justify-content:space-between;text-align:left;cursor:pointer">
            <span id="custom-role-label">Semua peran</span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#4A5780" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
        </button>
        <div class="custom-select-dropdown" id="custom-role-menu" style="display:none;position:absolute;top:calc(100% + 6px);left:0;right:0;background:#ffffff;border:2px solid var(--line-2);border-radius:12px;box-shadow:0 10px 25px rgba(15,27,61,0.12);z-index:50;overflow:hidden">
            <div class="custom-option active" data-value="" style="padding:10px 16px;cursor:pointer;font-weight:600;font-size:14px;color:var(--ink)">Semua peran</div>
            <div class="custom-option" data-value="siswa" style="padding:10px 16px;cursor:pointer;font-weight:600;font-size:14px;color:var(--ink)">Siswa</div>
            <div class="custom-option" data-value="admin" style="padding:10px 16px;cursor:pointer;font-weight:600;font-size:14px;color:var(--ink)">Admin</div>
        </div>
    </div>
</div>

<div class="tbl-wrap">
    <div class="tbl" style="--cols:1.6fr 1.6fr 1.1fr .8fr .6fr">
        <div class="tr th"><span>Nama</span><span>Email</span><span>NISN</span><span>Peran</span><span></span></div>
        @forelse ($users as $u)
            <div class="tr row" data-role="{{ $u->role }}" data-search="{{ strtolower($u->name . ' ' . $u->email . ' ' . $u->nisn) }}">
                <b>{{ $u->name }}</b>
                <span style="word-break:break-all">{{ $u->email }}</span>
                <span>{{ $u->nisn ?: '-' }}</span>
                <span><span class="badge {{ $u->role === 'admin' ? 'info' : 'ok' }}">{{ ucfirst($u->role) }}</span></span>
                <div class="row-actions">
                    @if ($u->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.user.destroy', $u->id) }}" onsubmit="return confirm('Hapus pengguna {{ addslashes($u->name) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="del">Hapus</button>
                        </form>
                    @else
                        <span class="ba">Anda</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty">Belum ada pengguna.</div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<style>
.custom-option:hover {
    background-color: var(--blue) !important;
    color: #ffffff !important;
}
.custom-option.active {
    background-color: var(--head);
    color: var(--blue);
}
</style>
<script>
const rows = [...document.querySelectorAll('.row')];
function filter() {
    const t = document.getElementById('q').value.trim().toLowerCase();
    const r = document.getElementById('f-role').value;
    rows.forEach(x => x.style.display = (!t || x.dataset.search.includes(t)) && (!r || x.dataset.role === r) ? '' : 'none');
}

// Logic Custom Dropdown
const roleBtn = document.getElementById('custom-role-btn');
const roleMenu = document.getElementById('custom-role-menu');
const roleLabel = document.getElementById('custom-role-label');
const roleInput = document.getElementById('f-role');
const options = document.querySelectorAll('.custom-option');

roleBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    roleMenu.style.display = roleMenu.style.display === 'none' ? 'block' : 'none';
});

options.forEach(opt => {
    opt.addEventListener('click', () => {
        options.forEach(o => o.classList.remove('active'));
        opt.classList.add('active');
        roleLabel.textContent = opt.textContent;
        roleInput.value = opt.dataset.value;
        roleMenu.style.display = 'none';
        filter();
    });
});

document.addEventListener('click', () => {
    roleMenu.style.display = 'none';
});

document.getElementById('q').addEventListener('input', filter);
</script>
@endpush