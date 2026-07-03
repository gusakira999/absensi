<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::livewire('/categories', 'pages::category.index')
    ->middleware(['auth'])
    ->name('category.index');
});

// Role-specific dashboards
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsureDosen;
use App\Http\Middleware\EnsureMahasiswa;

Route::get('admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified', EnsureAdmin::class])->name('admin.dashboard');

// Admin pages
Route::middleware(['auth', 'verified', EnsureAdmin::class])->group(function () {
    Route::livewire('admin/courses', 'pages::course.index')->name('admin.courses');
    Route::view('admin/schedules', 'admin.schedules')->name('admin.schedules');
    Route::view('admin/reports', 'admin.reports')->name('admin.reports');
});

Route::get('dosen/dashboard', function () {
    return view('dosen.dashboard');
})->middleware(['auth', 'verified', EnsureDosen::class])->name('dosen.dashboard');

// Dosen pages
Route::middleware(['auth', 'verified', EnsureDosen::class])->group(function () {
    Route::livewire('dosen/courses', 'pages::course.lecturer-list')->name('dosen.courses');
    Route::view('dosen/schedules', 'dosen.schedules')->name('dosen.schedules');
    Route::view('dosen/recap', 'dosen.recap')->name('dosen.recap');
    Route::view('dosen/reports', 'dosen.reports')->name('dosen.reports');
});

Route::get('mahasiswa/dashboard', function () {
    return view('mahasiswa.dashboard');
})->middleware(['auth', 'verified', EnsureMahasiswa::class])->name('mahasiswa.dashboard');

// Mahasiswa pages
Route::middleware(['auth', 'verified', EnsureMahasiswa::class])->group(function () {
    Route::livewire('mahasiswa/jadwal', 'pages::course.student-list')->name('mahasiswa.jadwal');
    Route::view('mahasiswa/absensi', 'mahasiswa.absensi')->name('mahasiswa.absensi');
    Route::view('mahasiswa/deadlines', 'mahasiswa.deadlines')->name('mahasiswa.deadlines');
    Route::view('mahasiswa/tracker', 'mahasiswa.tracker')->name('mahasiswa.tracker');
    Route::view('mahasiswa/notes', 'mahasiswa.notes')->name('mahasiswa.notes');
});


require __DIR__.'/settings.php';
