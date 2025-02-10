<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\SukuCadangController;
use App\Http\Controllers\JasaController;
use App\Http\Controllers\MekanikController;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/fake-login', function (Request $request) {
    // Ambil input dari form
    $username = $request->input('username'); 
    $password = $request->input('password');

    // Hardcoded credentials
    $correctUsername = 'admin';
    $correctPassword = 'admin123';

    if ($username === $correctUsername && $password === $correctPassword) {
        return redirect()->route('dashboard')->with('success', 'Login berhasil!');
    }

    return back()->with('error', 'Username atau password salah!');
})->name('fake-login');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('transaksi', TransaksiController::class);
Route::resource('pelanggan', PelangganController::class);
Route::resource('suku-cadang', SukuCadangController::class);
Route::resource('jasa', JasaController::class);
Route::resource('mekanik', MekanikController::class);
Route::get('/api/get-kendaraan/{id_pelanggan}', function ($id_pelanggan) {
    $kendaraan = DB::table('kendaraan')->where('id_pelanggan', $id_pelanggan)->first();
    return response()->json($kendaraan);
});


