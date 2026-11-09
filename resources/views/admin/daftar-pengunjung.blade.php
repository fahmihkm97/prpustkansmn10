@extends('layouts.admin')
@section('title', 'Daftar Pengunjung')

@section('content')
<div class="page-head">
    <div>
        <h1 class="s" style="margin-bottom:6px">Daftar Pengunjung</h1>
        <div class="ba">Riwayat kehadiran pengunjung perpustakaan</div>
    </div>
    <button type="button" class="btn" onclick="document.getElementById('dlg-tambah-pengunjung').showModal()">+ Catat Kunjungan</button>
</div>

<input class="input" id="q" style="max-width:420px;margin-bottom:20px" placeholder="Cari nama, kelas, atau keperluan">

<div class="tbl-wrap">
    <div class="tbl" style="--cols:1.5fr 1fr 2fr 1.2fr 1fr">
        <div class="tr th"><span>Nama Pengunjung</span><span>Kelas / NISN</span><span>Keperluan</span><span>Waktu Kunjungan</span><span></span></div>
        @forelse ($visitors as $v)
            <div class="tr row" data-search="{{ strtolower($v->name . ' ' . $v->identity . ' ' . $v->purpose) }}">
                <b>{{ $v->name }}</b>
                <span>{{ $v->identity ?? '-' }}</span>
                <span>{{ $v->purpose ?? 'Membaca / Meminjam Buku' }}</span>
                <span>{{ $v->created_at ? \Carbon\Carbon::parse($v->created_at)->format('d M Y, H:i') : '-' }}</span>
                <div class="row-actions">
                    <form method="POST" action="{{ route('admin.pengunjung.destroy', $v->id) }}" onsubmit="return confirm('Hapus data kunjungan {{ addslashes($v->name) }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="del">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty">Belum ada data pengunjung tercatat.</div>
        @endforelse
    </div>
</div>

{{-- Dialog Tambah Kunjungan Manual (Opsional) --}}
<dialog id="dlg-tambah-pengunjung">
    <form method="POST" action="{{ route('admin.pengunjung.store') }}">
        @csrf
        <div class="page-head" style="margin-bottom:18px">
            <div><h2 class="s" style="font-size:28px">Catat Kunjungan</h2><div class="ba">Tambah data pengunjung perpustakaan</div></div>
        </div>
        <div class="form-grid">
            <div class="span2"><label class="label">Nama Lengkap</label><input class="input" name="name" required placeholder="Nama pengunjung"></div>
            <div><label class="label">Kelas / NISN</label><input class="input" name="identity" placeholder="Contoh: XII IPA 1"></div>
            <div><label class="label">Keperluan</label><input class="input" name="purpose" placeholder="Contoh: Membaca buku"></div>
            <button class="btn btn-blue span2" type="submit">Simpan Kunjungan</button>
            <button class="btn btn-ghost span2" type="button" onclick="this.closest('dialog').close()">Batal</button>
        </div>
    </form>
</dialog>
@endsection

@push('scripts')
<script>
document.getElementById('q').addEventListener('input', e => {
    const t = e.target.value.trim().toLowerCase();
    document.querySelectorAll('.row').forEach(r => r.style.display = r.dataset.search.includes(t) ? '' : 'none');
});
</script>
@endpush