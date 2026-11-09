@extends('layouts.admin')
@section('title', 'Peminjaman Aktif')

@section('content')
<div class="page-head">
    <div>
        <h1 class="s" style="margin-bottom:6px">Peminjaman aktif</h1>
        <div class="ba">Buku yang sedang dipesan atau dipinjam siswa</div>
    </div>
    <a class="btn" href="{{ route('admin.proses-peminjaman') }}">Proses Peminjaman</a>
</div>

<input class="input" id="q" style="max-width:420px;margin-bottom:20px" placeholder="Cari kode, siswa, atau judul">

<div class="tbl-wrap">
    <div class="tbl" style="--cols:1fr 1.3fr 1.5fr 1fr 1fr 1.2fr">
        <div class="tr th"><span>Kode</span><span>Siswa</span><span>Buku</span><span>Tgl pinjam</span><span>Batas kembali</span><span>Status</span></div>
        @forelse ($borrowings as $b)
            <div class="tr row" data-search="{{ strtolower($b->trx_code . ' ' . optional($b->user)->name . ' ' . optional($b->buku)->title) }}">
                <b>{{ $b->trx_code }}</b>
                <span>{{ $b->user->name ?? '-' }}</span>
                <span>{{ $b->buku->title ?? '-' }}</span>
                <span>{{ $b->borrowed_at ? \Carbon\Carbon::parse($b->borrowed_at)->format('d M Y') : '-' }}</span>
                <span>{{ $b->due_date ? \Carbon\Carbon::parse($b->due_date)->format('d M Y') : '-' }}</span>
                <span>
                    @if ($b->status === 'PENDING')
                        <span class="badge wn">Menunggu diambil</span>
                    @else
                        <span class="badge ok">Dipinjam</span>
                    @endif
                </span>
            </div>
        @empty
            <div class="empty">Tidak ada peminjaman aktif.</div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('q').addEventListener('input', e => {
    const t = e.target.value.trim().toLowerCase();
    document.querySelectorAll('.row').forEach(r => r.style.display = r.dataset.search.includes(t) ? '' : 'none');
});
</script>
@endpush