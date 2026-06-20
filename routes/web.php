<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Halaman utama - redirect ke login kalau belum login
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Dashboard umum (semua role bisa akses)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ========================================
// HALAMAN KHUSUS ADMIN
// ========================================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// ========================================
// HALAMAN KHUSUS DOSEN
// ========================================
Route::middleware(['auth', 'role:dosen'])->group(function () {
    Route::get('/dosen', function () {
        return view('dosen.dashboard');
    })->name('dosen.dashboard');
});

// ========================================
// HALAMAN KHUSUS MAHASISWA
// ========================================
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/mahasiswa', function () {
        return view('mahasiswa.dashboard');
    })->name('mahasiswa.dashboard');
});