<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\SukuCadangController;
use App\Http\Controllers\JasaController;
use App\Http\Controllers\MekanikController;
use App\Http\Controllers\KuitansiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\AboutController;
use Illuminate\Http\Request;

// --- PUBLIC & GUEST ROUTES ---
Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return view('login');
    })->name('login');

    Route::get('/login', function () {
        return view('login');
    })->name('login.form');

    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::get('/cek-kuitansi', [KuitansiController::class, 'formCekKuitansi'])->name('cek-kuitansi');
Route::get('/cek-kuitansi/proses', [KuitansiController::class, 'cekKuitansi'])->name('cek-kuitansi.proses');
Route::get('/cek-kuitansi/{no_kuitansi}/detail', [KuitansiController::class, 'detailKuitansi'])->name('cek-kuitansi.detail');

// --- AUTH ROUTES (ADMIN) ---
Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('transaksi', TransaksiController::class);
    Route::put('/transaksi/{id}/update-status', [TransaksiController::class, 'updateStatus'])->name('transaksi.updateStatus');
    Route::put('/transaksi/{id}/update-status-v2', [TransaksiController::class, 'updateStatusOnIndex'])->name('transaksi.updateStatusOnIndex');
    
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('suku-cadang', SukuCadangController::class);
    Route::resource('jasa', JasaController::class);
    Route::resource('mekanik', MekanikController::class);

    Route::get('/api/get-kendaraan/{id_pelanggan}', function ($id_pelanggan) {
        $kendaraan = DB::table('kendaraan')->where('id_pelanggan', $id_pelanggan)->first();
        return response()->json($kendaraan);
    });

    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
    Route::delete('/logs/clear', [LogController::class, 'clear'])->name('logs.clear');
    Route::get('/monitor', [MonitorController::class, 'index'])->name('monitor.index');
    Route::get('/about', [AboutController::class, 'index'])->name('about.index');
});
