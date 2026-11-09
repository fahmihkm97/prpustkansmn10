@php
    $hasImage = !empty($cover_image ?? $book->cover_image ?? null);
    $imgPath = $hasImage ? asset('storage/' . ($cover_image ?? $book->cover_image)) : null;

    $palette = [
        ['#10B981', '#FFC93C', '#fff'],
        ['#1D4ED8', '#FF6B5B', '#fff'],
        ['#FFC93C', '#1D4ED8', '#0F1B3D'],
        ['#FF6B5B', '#FFE08A', '#0F1B3D'],
        ['#7C3AED', '#10B981', '#fff'],
        ['#0EA5E9', '#FFC93C', '#0F1B3D'],
        ['#065F46', '#FFC93C', '#fff'],
        ['#B45309', '#FFE08A', '#fff'],
    ];
    $p = $palette[crc32($title ?? 'Buku') % count($palette)];
@endphp

@if ($hasImage)
    <div class="bk {{ $class ?? '' }}" style="padding:0;background:#000;">
        <img src="{{ $imgPath }}" alt="{{ $title ?? 'Sampul Buku' }}" style="width:100%;height:100%;object-fit:cover;border-radius:inherit;">
    </div>
@else
    <div class="bk {{ $class ?? '' }}" style="background:{{ $p[0] }};--c2:{{ $p[1] }};color:{{ $p[2] }}">{{ $title ?? '' }}</div>
@endif