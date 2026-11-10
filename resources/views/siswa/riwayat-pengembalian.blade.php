@extends('layouts.siswa')
@section('title', 'Riwayat Pinjaman')

@section('content')
<div style="max-width:760px;margin:0 auto">
    <h1 class="s" style="font-size:32px;margin-bottom:14px">Riwayat pinjaman</h1>

    <div class="tabs" style="font-size:13px">
        <a class="tab" href="{{ route('siswa.peminjaman') }}">Aktif</a>
        <span class="tab on">Selesai</span>
    </div>

    @forelse ($returns as $r)
        @php $title = $r->buku->title ?? 'Buku'; @endphp
        <div class="loan" style="border-radius:18px">
            <!-- Cover Buku (Diperbaiki ke partials.sampul-buku) -->
            @include('partials.sampul-buku', ['title' => $title, 'class' => 'bk-sm'])
            
            <div class="info-col">
                <b style="font-size:15px">{{ $title }}</b>
                <div class="ba">Kode: <b>{{ $r->trx_code }}</b></div>
                <div class="ba">Dikembalikan {{ $r->returned_at ? \Carbon\Carbon::parse($r->returned_at)->format('d M Y') : '-' }}</div>
                <span class="badge ok" style="margin-top:6px">Selesai</span>
            </div>
        </div>
    @empty
        <div class="cd empty" style="padding:48px 22px">Belum ada buku yang dikembalikan.</div>
    @endforelse
</div>
@endsection