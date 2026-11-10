<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Import Controller Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\PeminjamanAdminController;
use App\Http\Controllers\Admin\PengembalianAdminController;
use App\Http\Controllers\Admin\SiswaTerlambatController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PengunjungController;

// Import Controller Siswa
use App\Http\Controllers\Siswa\KatalogController;
use App\Http\Controllers\Siswa\PeminjamanSiswaController;
use App\Http\Controllers\Siswa\PengembalianSiswaController;

// ==================== HALAMAN BERANDA PUBLIK ====================
Route::get('/', [KatalogController::class, 'publicIndex'])->name('beranda');

// ==================== AUTENTIKASI PUBLIK ====================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== ROUTE TERPROTEKSI AUTH ====================
Route::middleware(['auth'])->group(function () {

    // -------------------- AREA ADMIN --------------------
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard Utama
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Halaman & API Proses Peminjaman / Pengembalian
        Route::get('/proses-peminjaman', [PeminjamanAdminController::class, 'showProsesForm'])->name('proses-peminjaman');
        Route::get('/proses-peminjaman/detail/{trx_code}', [PeminjamanAdminController::class, 'getDetail'])->name('proses-peminjaman.detail');
        
        // Kelola Data Buku
        Route::get('/kelola-buku', [BukuController::class, 'index'])->name('kelola-buku');
        Route::post('/kelola-buku', [BukuController::class, 'store'])->name('buku.store');
        Route::put('/kelola-buku/{id}', [BukuController::class, 'update'])->name('buku.update');
        Route::delete('/kelola-buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');

        // Kelola Data User (Admin / Siswa)
        Route::get('/kelola-user', [UserController::class, 'index'])->name('kelola-user');
        Route::view('/tambah-user', 'admin.tambah-pengguna')->name('tambah-user');
        Route::post('/kelola-user', [UserController::class, 'store'])->name('user.store');
        Route::delete('/kelola-user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

        // Kelola Daftar Pengunjung Perpustakaan
        Route::get('/daftar-pengunjung', [PengunjungController::class, 'index'])->name('daftar-pengunjung');
        Route::post('/daftar-pengunjung', [PengunjungController::class, 'store'])->name('pengunjung.store');
        Route::delete('/daftar-pengunjung/{id}', [PengunjungController::class, 'destroy'])->name('pengunjung.destroy');

        // Data Peminjaman Aktif, Pengembalian, & Siswa Terlambat
        Route::get('/peminjaman-admin', [PeminjamanAdminController::class, 'indexAktif'])->name('peminjaman');
        Route::get('/data-pengembalian', [PengembalianAdminController::class, 'index'])->name('data-pengembalian');
        Route::get('/siswa-terlambat', [SiswaTerlambatController::class, 'index'])->name('siswa-terlambat');

        // Aksi Approval Penyerahan (Peminjaman) & Pengembalian Buku
        Route::post('/scan/pickup', [PeminjamanAdminController::class, 'approvePickup'])->name('peminjaman.approve');
        Route::post('/scan/return', [PengembalianAdminController::class, 'approveReturn'])->name('pengembalian.approve');
    });

    // -------------------- AREA SISWA --------------------
    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/katalog-buku', [KatalogController::class, 'index'])->name('katalog-buku');
        Route::get('/peminjaman-siswa', [PeminjamanSiswaController::class, 'index'])->name('peminjaman');
        Route::get('/riwayat-pengembalian', [PengembalianSiswaController::class, 'index'])->name('riwayat-pengembalian');
        
        // Proses Permintaan Pinjam Buku
        Route::post('/pinjam/{id}', [PeminjamanSiswaController::class, 'storeRequest'])->name('pinjam');
        Route::post('/request-pinjam', [PeminjamanSiswaController::class, 'storeRequest'])->name('peminjaman.store');
    });

});