@extends('layouts.admin')
@section('title', 'Data Pengembalian')

@section('content')
<div class="page-head">
    <div>
        <h1 class="s" style="margin-bottom:6px">Data pengembalian</h1>
        <div class="ba">Riwayat buku yang sudah dikembalikan</div>
    </div>
    <a class="btn" href="{{ route('admin.proses-peminjaman') }}">Proses Peminjaman</a>
</div>

<input class="input" id="q" style="max-width:420px;margin-bottom:20px" placeholder="Cari kode, siswa, atau judul">

<div class="tbl-wrap">
    <div class="tbl" style="--cols:1fr 1.3fr 1.5fr 1fr 1fr 1fr">
        <div class="tr th"><span>Kode</span><span>Siswa</span><span>Buku</span><span>Tgl pinjam</span><span>Dikembalikan</span><span>Status</span></div>
        @forelse ($returns as $r)
            @php
                $late = $r->due_date && $r->returned_at
                    && \Carbon\Carbon::parse($r->returned_at)->startOfDay()->gt(\Carbon\Carbon::parse($r->due_date)->startOfDay());
            @endphp
            <div class="tr row" data-search="{{ strtolower($r->trx_code . ' ' . optional($r->user)->name . ' ' . optional($r->buku)->title) }}">
                <b>{{ $r->trx_code }}</b>
                <span>{{ $r->user->name ?? '-' }}</span>
                <span>{{ $r->buku->title ?? '-' }}</span>
                <span>{{ $r->borrowed_at ? \Carbon\Carbon::parse($r->borrowed_at)->format('d M Y') : '-' }}</span>
                <span>{{ $r->returned_at ? \Carbon\Carbon::parse($r->returned_at)->format('d M Y') : '-' }}</span>
                <span><span class="badge {{ $late ? 'no' : 'ok' }}">{{ $late ? 'Terlambat' : 'Tepat waktu' }}</span></span>
            </div>
        @empty
            <div class="empty">Belum ada data pengembalian.</div>
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