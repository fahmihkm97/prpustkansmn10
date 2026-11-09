@php $available = $book->stock > 0; @endphp
<div class="book-card"
    data-title="{{ $book->title }}" data-author="{{ $book->author }}"
    data-cat="{{ $book->category }}" data-avail="{{ $available ? 1 : 0 }}">
    @include('partials.sampul-buku', ['title' => $book->title])
    <div class="bt">{{ $book->title }}</div>
    <div class="ba">{{ $book->author }}</div>
    <span class="badge {{ $available ? 'ok' : 'no' }}">{{ $available ? 'Tersedia · ' . $book->stock : 'Habis' }}</span>
    
    @if (($mode ?? 'pinjam') === 'pinjam')
        @if ($available)
            <form method="POST" action="{{ route('siswa.pinjam', $book->id) }}">
                @csrf
                <button type="submit" class="btn btn-blue btn-sm" style="margin-top:10px;width:100%">Pinjam</button>
            </form>
        @else
            <button type="button" class="btn btn-sm" disabled style="margin-top:10px;width:100%">Stok habis</button>
        @endif
    @else
        <a href="{{ route('login') }}" class="btn btn-blue btn-sm" style="margin-top:10px;width:100%">Masuk untuk pinjam</a>
    @endif
</div>