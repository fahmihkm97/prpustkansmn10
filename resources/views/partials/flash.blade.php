@if (session('success'))
    <div class="flash ok">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="flash no">{{ session('error') }}</div>
@endif
@if ($errors->any())
    <div class="flash no">
        <ul>
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif
