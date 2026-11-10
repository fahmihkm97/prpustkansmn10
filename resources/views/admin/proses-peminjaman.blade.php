@extends('layouts.admin')
@section('title', 'Proses Peminjaman & Pengembalian')

@section('content')
<div class="page-head">
    <div>
        <h1 class="s">Proses Peminjaman & Pengembalian</h1>
    </div>
</div>

<div style="max-width:680px;margin:0 auto">
    <!-- Pilihan Mode (Tab Peminjaman / Pengembalian) -->
    <div class="tabs" style="justify-content:center;margin-bottom:20px;">
        <button type="button" class="tab on" id="tab-pinjam" onclick="switchMode('PINJAM')">
            Peminjaman Buku
        </button>
        <button type="button" class="tab" id="tab-kembali" onclick="switchMode('KEMBALI')">
            Pengembalian Buku
        </button>
    </div>

    <!-- Form Input Kode -->
    <div class="cd" style="padding:28px;margin-bottom:24px;">
        <div style="margin-bottom:14px">
            <h2 class="s" id="mode-title" style="font-size:18px;color:var(--blue)">Input Kode Peminjaman</h2>
            <div class="muted" id="mode-desc" style="font-size:12px">Masukkan kode peminjaman siswa untuk memproses penyerahan buku.</div>
        </div>

        <label class="label" id="input-label">Kode Peminjaman</label>
        <div style="display:flex;gap:12px">
            <input class="input" id="trx_input" placeholder="Ketik kode (contoh: BOOK-1T27)" style="flex:1" autofocus autocomplete="off">
            <button type="button" class="btn btn-blue" id="btn-cek">Cek Kode</button>
        </div>
        <div id="trx-error" class="field-err" style="display:none;margin-top:10px;font-weight:600"></div>
    </div>

    <!-- Kartu Informasi Detail Peminjaman -->
    <div class="cd" id="detail-card" style="display:none;padding:28px">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
            <h2 class="s" style="font-size:20px">Detail Peminjaman</h2>
            <span id="d-badge" class="badge"></span>
        </div>

        <div style="margin-bottom:24px">
            <div class="rrow">
                <span class="muted">Kode Peminjaman</span>
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

        <!-- Tombol Aksi Sesuai Status dan Mode -->
        <div id="action-area"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentMode = 'PINJAM';

const inputTrx = document.getElementById('trx_input');
const btnCek = document.getElementById('btn-cek');
const errBox = document.getElementById('trx-error');
const detailCard = document.getElementById('detail-card');

function switchMode(mode) {
    currentMode = mode;
    detailCard.style.display = 'none';
    errBox.style.display = 'none';
    inputTrx.value = '';

    const tabPinjam = document.getElementById('tab-pinjam');
    const tabKembali = document.getElementById('tab-kembali');
    const modeTitle = document.getElementById('mode-title');
    const modeDesc = document.getElementById('mode-desc');
    const inputLabel = document.getElementById('input-label');

    if (mode === 'PINJAM') {
        tabPinjam.classList.add('on');
        tabKembali.classList.remove('on');
        
        modeTitle.textContent = 'Input Kode Peminjaman';
        modeTitle.style.color = 'var(--blue)';
        modeDesc.textContent = 'Masukkan kode peminjaman siswa untuk memproses penyerahan buku.';
        inputLabel.textContent = 'Kode Peminjaman';
        inputTrx.placeholder = 'Ketik kode (contoh: BOOK-1T27)';
        btnCek.className = 'btn btn-blue';
    } else {
        tabKembali.classList.add('on');
        tabPinjam.classList.remove('on');
        
        modeTitle.textContent = 'Input Kode Pengembalian';
        modeTitle.style.color = 'var(--ok-fg)';
        modeDesc.textContent = 'Masukkan kode pengembalian siswa untuk mengonfirmasi pengembalian buku.';
        inputLabel.textContent = 'Kode Pengembalian';
        inputTrx.placeholder = 'Ketik kode (contoh: BOOK-1T27)';
        btnCek.className = 'btn';
        btnCek.style.background = 'var(--ok-bg)';
        btnCek.style.color = 'var(--ok-fg)';
    }
    inputTrx.focus();
}

function cariTransaksi() {
    const code = inputTrx.value.trim();
    errBox.style.display = 'none';
    
    if (!code) {
        errBox.textContent = `Silahkan masukkan kode ${currentMode === 'PINJAM' ? 'peminjaman' : 'pengembalian'} terlebih dahulu.`;
        errBox.style.display = 'block';
        return;
    }

    btnCek.disabled = true;
    btnCek.textContent = 'Mencari...';

    fetch(`/admin/proses-peminjaman/detail/${encodeURIComponent(code)}`)
        .then(res => res.json())
        .then(res => {
            btnCek.disabled = false;
            btnCek.textContent = 'Cek Kode';

            if (!res.success) {
                detailCard.style.display = 'none';
                errBox.textContent = res.message || 'Kode tidak ditemukan.';
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
                if (currentMode === 'PINJAM') {
                    actionArea.innerHTML = `
                        <button type="button" class="btn btn-blue btn-block" onclick="prosesSerahkan('${data.trx_code}')">
                            ✓ Serahkan Buku ke Siswa (Ubah ke DIPINJAM)
                        </button>
                    `;
                } else {
                    actionArea.innerHTML = `
                        <div style="text-align:center;padding:14px;background:var(--wn-bg);color:var(--wn-fg);border-radius:12px;font-weight:700">
                            Status peminjaman ini masih PENDING (Belum diserahkan ke siswa). Silahkan gunakan menu Penyerahan Buku terlebih dahulu.
                        </div>
                    `;
                }
            } else if (data.status === 'DIPINJAM' || data.status === 'TERLAMBAT') {
                if (currentMode === 'KEMBALI') {
                    actionArea.innerHTML = `
                        <button type="button" class="btn btn-block" style="background:var(--ok-bg);color:var(--ok-fg);font-size:14px" onclick="prosesKembalikan('${data.trx_code}')">
                            ✓ Konfirmasi Pengembalian Buku
                        </button>
                    `;
                } else {
                    actionArea.innerHTML = `
                        <div style="text-align:center;padding:14px;background:var(--info-bg);color:var(--info-fg);border-radius:12px;font-weight:700">
                            Buku ini sedang dipinjam siswa. Untuk mengembalikan, silahkan pindah ke Tab "Pengembalian Buku".
                        </div>
                    `;
                }
            } else if (data.status === 'DIKEMBALIKAN') {
                actionArea.innerHTML = `
                    <div style="text-align:center;padding:14px;background:var(--head);border-radius:12px;font-weight:700;color:var(--muted)">
                        Peminjaman ini sudah selesai (Buku Dikembalikan).
                    </div>
                `;
            }

            detailCard.style.display = 'block';
        })
        .catch(() => {
            btnCek.disabled = false;
            btnCek.textContent = 'Cek Kode';
            errBox.textContent = 'Terjadi kesalahan sistem saat mengambil data.';
            errBox.style.display = 'block';
        });
}

function prosesSerahkan(code) {
    const today = new Date();
    today.setDate(today.getDate() + 7);
    const defaultDate = today.toISOString().split('T')[0];

    Swal.fire({
        title: 'Konfirmasi Penyerahan Buku',
        html: `
            <div style="text-align:left;font-size:14px">
                <p style="margin-bottom:12px">Konfirmasi penyerahan buku untuk kode <b>${code}</b>?</p>
                <label style="font-weight:600;display:block;margin-bottom:6px">Atur Batas Tanggal Pengembalian:</label>
                <input type="date" id="swal-due-date" class="swal2-input" value="${defaultDate}" style="margin:0;width:100%;box-sizing:border-box">
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#1D4ED8',
        cancelButtonColor: '#4A5780',
        confirmButtonText: 'Ya, Serahkan',
        cancelButtonText: 'Batal',
        preConfirm: () => {
            const dueDate = document.getElementById('swal-due-date').value;
            if (!dueDate) {
                Swal.showValidationMessage('Silahkan pilih batas tanggal pengembalian!');
            }
            return dueDate;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('{{ route("admin.peminjaman.approve") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ trx_code: code, due_date: result.value })
            })
            .then(r => r.json())
            .then(res => {
                Swal.fire({
                    icon: res.success ? 'success' : 'error',
                    title: res.success ? 'Berhasil!' : 'Gagal!',
                    text: res.message,
                    timer: res.success ? 2000 : undefined,
                    showConfirmButton: !res.success
                });
                if (res.success) cariTransaksi();
            });
        }
    });
}

function prosesKembalikan(code) {
    Swal.fire({
        title: 'Konfirmasi Pengembalian Buku',
        text: `Konfirmasi pengembalian buku untuk kode ${code}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#059669',
        cancelButtonColor: '#4A5780',
        confirmButtonText: 'Ya, Kembalikan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
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
                Swal.fire({
                    icon: res.success ? 'success' : 'error',
                    title: res.success ? 'Berhasil!' : 'Gagal!',
                    text: res.message,
                    timer: res.success ? 2000 : undefined,
                    showConfirmButton: !res.success
                });
                if (res.success) cariTransaksi();
            });
        }
    });
}

btnCek.addEventListener('click', cariTransaksi);
inputTrx.addEventListener('keypress', e => {
    if (e.key === 'Enter') cariTransaksi();
});
</script>
@endpush