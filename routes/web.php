<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;

// Route home
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');

// Dashboard umum
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ========================================
// HALAMAN KHUSUS ADMIN
// ========================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('dosen', DosenController::class);
});

// Halaman khusus dosen
Route::middleware(['auth', 'role:dosen'])->group(function () {
    Route::get('/dosen', function () {
        return view('dosen.dashboard');
    })->name('dosen.dashboard');
});

// Halaman khusus mahasiswa
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/mahasiswa', function () {
        return view('mahasiswa.dashboard');
    })->name('mahasiswa.dashboard');
});