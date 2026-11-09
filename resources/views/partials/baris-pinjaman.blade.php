@php
    $map = ['PENDING' => ['wn', 'Menunggu diambil'], 'DIPINJAM' => ['ok', 'Dipinjam'], 'TERLAMBAT' => ['no', 'Terlambat'], 'DIKEMBALIKAN' => ['info', 'Dikembalikan']];
    [$cls, $label] = $map[$l->status] ?? ['info', $l->status];
@endphp
<div class="tr">
    <b>{{ $l->trx_code }}</b>
    <span>{{ $l->buku->title ?? '-' }}</span>
    <span>{{ $l->due_date ? \Carbon\Carbon::parse($l->due_date)->format('d M Y') : '-' }}</span>
    <span><span class="badge {{ $cls }}">{{ $label }}</span></span>
</div>
