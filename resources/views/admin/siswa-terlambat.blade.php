@extends('layouts.admin')
@section('title', 'Siswa Terlambat')

@section('content')
<div class="page-head">
    <div>
        <h1 class="s" style="margin-bottom:6px">Siswa terlambat</h1>
        <div class="ba">Perlu diingatkan untuk mengembalikan buku</div>
    </div>
</div>

<input class="input" id="q" style="max-width:420px;margin-bottom:20px" placeholder="Cari kode, siswa, atau judul">

<div class="tbl-wrap">
    <div class="tbl" style="--cols:1fr 1.3fr 1.5fr 1fr 1fr">
        <div class="tr th"><span>Kode</span><span>Siswa</span><span>Buku</span><span>Batas kembali</span><span>Terlambat</span></div>
        @forelse ($overdueLoans as $o)
            @php
                $due  = $o->due_date ? \Carbon\Carbon::parse($o->due_date)->startOfDay() : null;
                $days = $due ? max(0, (int) $due->diffInDays(now()->startOfDay())) : null;
            @endphp
            <div class="tr row" data-search="{{ strtolower($o->trx_code . ' ' . optional($o->user)->name . ' ' . optional($o->buku)->title) }}">
                <b>{{ $o->trx_code }}</b>
                <span>
                    {{ $o->user->name ?? '-' }}
                    @if (optional($o->user)->nisn)<div class="ba">{{ $o->user->nisn }}</div>@endif
                </span>
                <span>{{ $o->buku->title ?? '-' }}</span>
                <span>{{ $due ? $due->format('d M Y') : '-' }}</span>
                <span><span class="badge no">{{ $days === null ? 'Terlambat' : ($days . ' hari') }}</span></span>
            </div>
        @empty
            <div class="empty">Tidak ada siswa yang terlambat. 🎉</div>
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
