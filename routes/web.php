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
use App\Http\Controllers\JanjiController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnamnesaController;
use App\Http\Controllers\PasienController;

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
    // Di web.php
    Route::middleware(['auth'])->group(function () {
        // Routes untuk pasien
        Route::get('/buat-janji', [JanjiController::class, 'index'])->name('janji.index');
        Route::post('/buat-janji', [JanjiController::class, 'store'])->name('janji.store');
        Route::get('/janji-saya', [JanjiController::class, 'myAppointments'])->name('janji.my');
        Route::put('/janji/{id}/cancel', [JanjiController::class, 'cancel'])->name('janji.cancel');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/profil', [PasienController::class, 'profil'])->name('pasien.profil');
        Route::put('/profil/{id}', [PasienController::class, 'update'])->name('pasien.update');
    });
    // Dokter mengisi anamnesa
    Route::middleware(['auth'])->group(function () {
        Route::get('/anamnesa/{janji_id}', [AnamnesaController::class, 'create'])->name('anamnesa.create');
        Route::post('/anamnesa', [AnamnesaController::class, 'store'])->name('anamnesa.store');
    });

    Route::prefix('pasien')->name('pasien.')->group(function () {
        Route::get('/riwayat', [DashboardPasienController::class, 'appointmentHistory'])->name('riwayat');
        Route::get('/pembayaran', [DashboardPasienController::class, 'payment'])->name('pembayaran');
        Route::patch('/batalkan-janji/{id}', [DashboardPasienController::class, 'cancelAppointment'])->name('cancel-appointment');
    });

    // =======================
    // Fitur untuk Dokter
    // =======================
    Route::middleware(['auth'])->group(function () {
        Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
        Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
        Route::put('/jadwal/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
        Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
    });

    // =======================
    // Fitur untuk Admin
    // =======================

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard.admin');
});


    Route::middleware(['auth'])->group(function () {
        Route::get('/dokter', [DokterController::class, 'index'])->name('dokter.index');
        Route::post('/dokter', [DokterController::class, 'store'])->name('dokter.store');
        Route::put('/dokter/{id}', [DokterController::class, 'update'])->name('dokter.update');
        Route::delete('/dokter/{id}', [DokterController::class, 'destroy'])->name('dokter.destroy');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('user.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/users', [UserController::class, 'store'])->name('user.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    });



    
Route::middleware(['auth'])->prefix('data-pasien')->group(function () {
    Route::get('/', [PasienController::class, 'index'])->name('pasien.index');
    Route::post('/', [PasienController::class, 'store'])->name('pasien.store');
    Route::put('/{id}', [PasienController::class, 'update'])->name('pasien.update');
    Route::delete('/{id}', [PasienController::class, 'destroy'])->name('pasien.destroy');
});



});
