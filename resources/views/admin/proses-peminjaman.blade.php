@extends('layouts.admin')
@section('title', 'Proses Peminjaman')

@section('content')
<div class="page-head">
    <div>
        <h1 class="s">Proses Peminjaman</h1>
        <div class="ba">Masukkan Kode Transaksi (BOOK) untuk mengecek detail serta memproses penyerahan / pengembalian buku</div>
    </div>
</div>

<div style="max-width:640px;margin:0 auto">
    <!-- Form Pencarian Kode TRX -->
    <div class="cd" style="padding:28px;margin-bottom:24px">
        <label class="label">Kode Pinjaman</label>
        <div style="display:flex;gap:12px">
            <input class="input" id="trx_input" placeholder="Ketik kode (contoh: BOOK-8F9A2B)" style="flex:1" autofocus autocomplete="off">
            <button type="button" class="btn btn-blue" id="btn-cek">Cek Transaksi</button>
        </div>
        <div id="trx-error" class="field-err" style="display:none;margin-top:10px;font-weight:600"></div>
    </div>

    <!-- Kartu Informasi Detail Transaksi -->
    <div class="cd" id="detail-card" style="display:none;padding:28px">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
            <h2 class="s" style="font-size:20px">Detail Transaksi</h2>
            <span id="d-badge" class="badge"></span>
        </div>

        <div style="margin-bottom:24px">
            <div class="rrow">
                <span class="muted">Kode Transaksi</span>
                <b id="d-trx" style="color:var(--blue)">-</b>
            </div>
            <div class="rrow">
                <span class="muted">Nama Siswa</span>
                <b id="d-user">-</b>
            </div>
            <div class="rrow">
                <span class="muted">Judul Buku</span>
                <b id="d-book">-</b>
            </div>
            <div class="rrow">
                <span class="muted">Batas Pengembalian</span>
                <b id="d-due">-</b>
            </div>
        </div>

        <!-- Tombol Aksi Otomatis Sesuai Status -->
        <div id="action-area"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const inputTrx = document.getElementById('trx_input');
const btnCek = document.getElementById('btn-cek');
const errBox = document.getElementById('trx-error');
const detailCard = document.getElementById('detail-card');

function cariTransaksi() {
    const code = inputTrx.value.trim();
    errBox.style.display = 'none';
    
    if (!code) {
        errBox.textContent = 'Silahkan masukkan kode transaksi terlebih dahulu.';
        errBox.style.display = 'block';
        return;
    }

    btnCek.disabled = true;
    btnCek.textContent = 'Mencari...';

    fetch(`/admin/proses-peminjaman/detail/${encodeURIComponent(code)}`)
        .then(res => res.json())
        .then(res => {
            btnCek.disabled = false;
            btnCek.textContent = 'Cek Transaksi';

            if (!res.success) {
                detailCard.style.display = 'none';
                errBox.textContent = res.message || 'Kode transaksi tidak ditemukan.';
                errBox.style.display = 'block';
                return;
            }

            const data = res.data;
            document.getElementById('d-trx').textContent = data.trx_code;
            document.getElementById('d-user').textContent = data.user_name;
            document.getElementById('d-book').textContent = data.book_title;
            document.getElementById('d-due').textContent = data.due_date;

            const badge = document.getElementById('d-badge');
            badge.textContent = data.status;
            badge.className = 'badge ' + (
                data.status === 'PENDING' ? 'wn' :
                data.status === 'DIPINJAM' ? 'info' :
                data.status === 'TERLAMBAT' ? 'no' : 'ok'
            );

            const actionArea = document.getElementById('action-area');
            actionArea.innerHTML = '';

            if (data.status === 'PENDING') {
                actionArea.innerHTML = `
                    <button type="button" class="btn btn-blue btn-block" onclick="prosesSerahkan('${data.trx_code}')">
                        ✓ Serahkan Buku ke Siswa (Ubah ke DIPINJAM)
                    </button>
                `;
            } else if (data.status === 'DIPINJAM' || data.status === 'TERLAMBAT') {
                actionArea.innerHTML = `
                    <button type="button" class="btn btn-block" style="background:var(--ok-bg);color:var(--ok-fg)" onclick="prosesKembalikan('${data.trx_code}')">
                        ✓ Konfirmasi Pengembalian Buku
                    </button>
                `;
            } else if (data.status === 'DIKEMBALIKAN') {
                actionArea.innerHTML = `
                    <div style="text-align:center;padding:14px;background:var(--head);border-radius:12px;font-weight:700;color:var(--muted)">
                        Transaksi ini sudah selesai (Buku Dikembalikan).
                    </div>
                `;
            }

            detailCard.style.display = 'block';
        })
        .catch(() => {
            btnCek.disabled = false;
            btnCek.textContent = 'Cek Transaksi';
            errBox.textContent = 'Terjadi kesalahan sistem saat mengambil data.';
            errBox.style.display = 'block';
        });
}

function prosesSerahkan(code) {
    if (!confirm(`Konfirmasi penyerahan buku untuk transaksi ${code}?`)) return;

    fetch('{{ route("admin.peminjaman.approve") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ trx_code: code })
    })
    .then(r => r.json())
    .then(res => {
        alert(res.message);
        if (res.success) cariTransaksi();
    });
}

function prosesKembalikan(code) {
    if (!confirm(`Konfirmasi pengembalian buku untuk transaksi ${code}?`)) return;

    fetch('{{ route("admin.pengembalian.approve") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ trx_code: code })
    })
    .then(r => r.json())
    .then(res => {
        alert(res.message);
        if (res.success) cariTransaksi();
    });
}

btnCek.addEventListener('click', cariTransaksi);
inputTrx.addEventListener('keypress', e => {
    if (e.key === 'Enter') cariTransaksi();
});
</script>
@endpush