<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Perpustakaan') — Perpustakaan SMAN 10 Semarang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,700&family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=1.1">
    @stack('styles')
</head>
<body>
    <div class="admin">
        <!-- Sidebar Mobile Topbar -->
        <div class="mobile-topbar">
            <button type="button" class="hamburger-btn" id="sidebar-toggle" aria-label="Toggle menu">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <div style="display:flex; align-items:center; gap:8px;">
                <img src="{{ asset('images/LOGOSMANTEN10.png') }}" alt="Logo SMAN 10" style="height:26px; width:auto;">
                <div class="brand s" style="font-size:17px;">Perpustakaan SMAN 10</div>
            </div>
        </div>

        <div class="sidebar-backdrop" id="sidebar-backdrop"></div>

        <!-- Sidebar Utama Admin -->
        <aside class="side" id="sidebar">
            <div class="side-head" style="display:flex; align-items:center; gap:10px;">
                <img src="{{ asset('images/LOGOSMANTEN10.png') }}" alt="Logo SMAN 10 Semarang" style="height:36px; width:auto; object-fit:contain;">
                <div style="flex:1;">
                    <h1 class="brand s" style="font-size:18px; margin:0; line-height:1.2;">Perpustakaan</h1>
                    <div class="sub" style="font-size:10px;">PANEL PETUGAS SMAN 10</div>
                </div>
                <button type="button" class="hamburger-btn side-close-btn" id="sidebar-close" aria-label="Tutup menu">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            @php
                $menu = [
                    ['route' => 'admin.dashboard', 'pattern' => 'admin.dashboard*', 'label' => 'Dashboard Utama', 'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>'],
                    ['route' => 'admin.proses-peminjaman', 'pattern' => 'admin.proses-peminjaman*', 'label' => 'Proses Peminjaman', 'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>'],
                    ['route' => 'admin.kelola-buku', 'pattern' => 'admin.kelola-buku*', 'label' => 'Kelola Data Buku', 'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>'],
                    ['route' => 'admin.daftar-pengunjung', 'pattern' => 'admin.daftar-pengunjung*', 'label' => 'Daftar Pengunjung', 'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>'],
                    ['route' => 'admin.peminjaman', 'pattern' => 'admin.peminjaman*', 'label' => 'Data Peminjaman Aktif', 'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>'],
                    ['route' => 'admin.data-pengembalian', 'pattern' => 'admin.data-pengembalian*', 'label' => 'Data Pengembalian', 'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>'],
                    ['route' => 'admin.siswa-terlambat', 'pattern' => 'admin.siswa-terlambat*', 'label' => 'Data Siswa Terlambat', 'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>'],
                    ['route' => 'admin.kelola-user', 'pattern' => 'admin.kelola-user*', 'label' => 'Kelola User (Admin/Siswa)', 'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>'],
                ];
            @endphp

            <nav class="side-menu">
                @foreach ($menu as $item)
                    <a href="{{ route($item['route']) }}" class="nav-i {{ request()->routeIs($item['pattern']) ? 'on' : '' }}">
                        {!! $item['icon'] !!}
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="spacer"></div>

            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    <span>Keluar (Petugas Perpustakaan)</span>
                </button>
            </form>
        </aside>

        <!-- Main Content -->
        <main class="main">
            @yield('content')
        </main>
    </div>

    <!-- Script Navigation Mobile -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');
        const toggleBtn = document.getElementById('sidebar-toggle');
        const closeBtn = document.getElementById('sidebar-close');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.add('active');
                backdrop.classList.add('active');
            });
        }

        function closeMenu() {
            sidebar.classList.remove('active');
            backdrop.classList.remove('active');
        }

        if (closeBtn) closeBtn.addEventListener('click', closeMenu);
        if (backdrop) backdrop.addEventListener('click', closeMenu);
    </script>

    <!-- SweetAlert2 CDN & Handler Notifikasi Global -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 2000,
                    showConfirmButton: false,
                    position: 'center'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#1D4ED8',
                    confirmButtonText: 'Tutup'
                });
            @endif

            @if (session('warning'))
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian!',
                    text: "{{ session('warning') }}",
                    confirmButtonColor: '#1D4ED8',
                    confirmButtonText: 'Mengerti'
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan!',
                    html: `<ul style="text-align:left; margin:0; padding-left:20px;">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>`,
                    confirmButtonColor: '#1D4ED8',
                    confirmButtonText: 'Tutup'
                });
            @endif

            window.alert = function (message) {
                Swal.fire({
                    title: 'Informasi',
                    text: message,
                    icon: 'info',
                    confirmButtonColor: '#1D4ED8',
                    confirmButtonText: 'OK'
                });
            };

            document.addEventListener('submit', function (e) {
                const form = e.target;
                const onsubmitAttr = form.getAttribute('onsubmit') || '';
                const isDeleteMethod = form.querySelector('input[name="_method"][value="DELETE"]');
                
                if (isDeleteMethod || onsubmitAttr.includes('confirm')) {
                    if (!form.dataset.confirmed) {
                        e.preventDefault();

                        let textMessage = 'Apakah Anda yakin ingin menghapus data ini?';
                        const matchText = onsubmitAttr.match(/confirm\(['"](.*?)['"]\)/);
                        if (matchText && matchText[1]) {
                            textMessage = matchText[1].replace(/\\'/g, "'").replace(/\\"/g, '"');
                        }

                        form.removeAttribute('onsubmit');

                        Swal.fire({
                            title: 'Konfirmasi Hapus',
                            text: textMessage,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#DC2626',
                            cancelButtonColor: '#4A5780',
                            confirmButtonText: 'Ya, Hapus',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.dataset.confirmed = "true";
                                form.submit();
                            }
                        });
                    }
                }
            }, true);
        });
    </script>
    @stack('scripts')
</body>
</html>