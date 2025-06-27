<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Import semua controller di sini
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\PelaporanController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DashboardDokterController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardPasienController;

// ==========================
// Halaman Welcome (publik)
// ==========================
Route::get('/', function () {
    return view('welcome');
});

// ==========================
// Auth Routes (login, register, dll)
// ==========================
Auth::routes();

// ==========================
// Dashboard Home (redirect default setelah login)
// ==========================
Route::get('/home', [HomeController::class, 'index'])->name('home');

// ==========================
// Route Khusus yang Memerlukan Login
// ==========================
Route::middleware(['auth'])->group(function () {

    // =======================
    // Dashboard Per Role
    // =======================
    Route::get('home-dokter', [DashboardDokterController::class, 'index'])->name('home-dokter');
    Route::get('home-admin', [DashboardAdminController::class, 'index'])->name('home-admin');
    Route::get('home-pasien', [DashboardPasienController::class, 'index'])->name('home-pasien');

    // =======================
    // Obat
    // =======================
    Route::resource('obat', ObatController::class)->except(['create', 'edit', 'show']);

    // =======================
    // Kunjungan
    // =======================
    Route::resource('kunjungan', KunjunganController::class)->except(['create', 'edit', 'show']);

    // =======================
    // Detail Transaksi
    // =======================
    Route::resource('detail-transaksi', DetailTransaksiController::class)->except(['create', 'edit', 'show']);

    // =======================
    // Pelaporan
    // =======================
    Route::resource('pelaporan', PelaporanController::class)->except(['create', 'edit', 'show']);

    // =======================
    // Rekam Medis
    // =======================
    Route::resource('rekam-medis', RekamMedisController::class)->except(['create', 'edit', 'show']);

    // =======================
    // Transaksi
    // =======================
    Route::resource('transaksi', TransaksiController::class)->except(['create', 'edit', 'show']);

    // =======================
    // Fitur untuk Pasien
    // =======================
    Route::prefix('pasien')->name('pasien.')->group(function () {
        Route::get('/buat-janji', [DashboardPasienController::class, 'createAppointment'])->name('buat-janji');
        Route::post('/buat-janji', [DashboardPasienController::class, 'storeAppointment'])->name('store-janji');
        Route::get('/riwayat', [DashboardPasienController::class, 'appointmentHistory'])->name('riwayat');
        Route::get('/pembayaran', [DashboardPasienController::class, 'payment'])->name('pembayaran');
        Route::get('/profil', [DashboardPasienController::class, 'profile'])->name('profil');
        Route::patch('/batalkan-janji/{id}', [DashboardPasienController::class, 'cancelAppointment'])->name('cancel-appointment');
    });
});
