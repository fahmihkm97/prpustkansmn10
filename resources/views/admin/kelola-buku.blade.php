@extends('layouts.admin')
@section('title', 'Kelola Buku')

@section('content')
<div class="page-head">
    <h1 class="s">Koleksi buku</h1>
    <button type="button" class="btn" onclick="document.getElementById('dlg-add').showModal()">+ Tambah buku</button>
</div>

<input class="input" id="q" style="max-width:420px;margin-bottom:20px" placeholder="Cari judul atau penulis">

<div class="tbl-wrap">
    <div class="tbl" style="--cols:64px 2fr 1.4fr 1fr .7fr 1fr 1fr">
        <div class="tr th">
            <span>Sampul</span>
            <span>Judul</span>
            <span>Penulis</span>
            <span>Kategori</span>
            <span>Stok</span>
            <span>Status</span>
            <span></span>
        </div>
        @forelse ($books as $b)
            <div class="tr row" data-search="{{ strtolower($b->title . ' ' . $b->author . ' ' . $b->category) }}">
                <div>
                    @if ($b->cover_image)
                        <img src="{{ asset('storage/' . $b->cover_image) }}" alt="{{ $b->title }}" style="width:40px;height:56px;object-fit:cover;border-radius:6px">
                    @else
                        <div style="width:40px;height:56px;background:var(--head);border-radius:6px;display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--muted);font-size:12px">
                            {{ strtoupper(substr($b->title, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <b>{{ $b->title }}</b>
                <span>{{ $b->author }}</span>
                <span>{{ $b->category }}</span>
                <span>{{ $b->stock }}</span>
                <span><span class="badge {{ $b->stock > 0 ? 'ok' : 'no' }}">{{ $b->stock > 0 ? 'Tersedia' : 'Habis' }}</span></span>
                <div class="row-actions">
                    <button type="button" class="js-edit"
                        data-action="{{ route('admin.buku.update', $b->id) }}"
                        data-title="{{ $b->title }}" data-author="{{ $b->author }}"
                        data-category="{{ $b->category }}" data-stock="{{ $b->stock }}">Ubah</button>
                    <form method="POST" action="{{ route('admin.buku.destroy', $b->id) }}" onsubmit="return confirm('Hapus buku &quot;{{ addslashes($b->title) }}&quot;?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="del">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty">Belum ada buku. Klik “+ Tambah buku” untuk memulai.</div>
        @endforelse
    </div>
</div>

<datalist id="kategori-list">
    @foreach ($books->pluck('category')->filter()->unique()->sort() as $c)
        <option value="{{ $c }}">
    @endforeach
    <option value="Fiksi"><option value="Sains"><option value="Sejarah"><option value="Pelajaran"><option value="Referensi">
</datalist>

{{-- Tambah --}}
<dialog id="dlg-add">
    <form method="POST" action="{{ route('admin.buku.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="page-head" style="margin-bottom:18px">
            <div><h2 class="s" style="font-size:28px">Tambah buku</h2><div class="ba">Isi data buku baru</div></div>
        </div>
        <div class="form-grid">
            <div class="span2"><label class="label">Judul buku</label><input class="input" name="title" required placeholder="Judul"></div>
            <div><label class="label">Penulis</label><input class="input" name="author" required placeholder="Nama penulis"></div>
            <div><label class="label">Kategori</label><input class="input" name="category" list="kategori-list" required placeholder="Pilih / ketik kategori"></div>
            <div><label class="label">Jumlah eksemplar</label><input class="input" type="number" name="stock" min="0" value="1" required></div>
            <div><label class="label">Gambar sampul</label><input class="input" type="file" name="cover_image" accept="image/*" style="padding-top:10px"></div>
            <button class="btn btn-blue span2" type="submit">Simpan buku</button>
            <button class="btn btn-ghost span2" type="button" onclick="this.closest('dialog').close()">Batal</button>
        </div>
    </form>
</dialog>

{{-- Ubah --}}
<dialog id="dlg-edit">
    <form method="POST" id="form-edit" action="" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="page-head" style="margin-bottom:18px">
            <div><h2 class="s" style="font-size:28px">Ubah buku</h2></div>
        </div>
        <div class="form-grid">
            <div class="span2"><label class="label">Judul buku</label><input class="input" name="title" id="e-title" required></div>
            <div><label class="label">Penulis</label><input class="input" name="author" id="e-author" required></div>
            <div><label class="label">Kategori</label><input class="input" name="category" id="e-category" list="kategori-list" required></div>
            <div><label class="label">Jumlah eksemplar</label><input class="input" type="number" name="stock" id="e-stock" min="0" required></div>
            <div><label class="label">Ganti gambar (opsional)</label><input class="input" type="file" name="cover_image" accept="image/*" style="padding-top:10px"></div>
            <button class="btn btn-blue span2" type="submit">Simpan perubahan</button>
            <button class="btn btn-ghost span2" type="button" onclick="this.closest('dialog').close()">Batal</button>
        </div>
    </form>
</dialog>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.js-edit').forEach(btn => btn.addEventListener('click', () => {
    const d = btn.dataset;
    document.getElementById('form-edit').action = d.action;
    document.getElementById('e-title').value = d.title;
    document.getElementById('e-author').value = d.author;
    document.getElementById('e-category').value = d.category;
    document.getElementById('e-stock').value = d.stock;
    document.getElementById('dlg-edit').showModal();
}));
document.getElementById('q').addEventListener('input', e => {
    const t = e.target.value.trim().toLowerCase();
    document.querySelectorAll('.row').forEach(r => r.style.display = r.dataset.search.includes(t) ? '' : 'none');
});
@if ($errors->any() && old('title') !== null)
document.getElementById('dlg-add').showModal();
@endif
</script>
@endpush