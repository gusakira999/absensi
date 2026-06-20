@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Selamat Datang, {{ auth()->user()->name }}!</h3>
                    <p class="mb-6">Silakan pilih dashboard sesuai role kamu:</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="block p-6 bg-red-50 hover:bg-red-100 rounded-lg transition">
                                <h4 class="text-lg font-bold text-red-600 mb-2">Dashboard Admin</h4>
                                <p class="text-sm text-gray-600">Kelola data mahasiswa, dosen, dan mata kuliah</p>
                            </a>
                        @endif

                        @if(auth()->user()->isDosen())
                            <a href="{{ route('dosen.dashboard') }}" class="block p-6 bg-green-50 hover:bg-green-100 rounded-lg transition">
                                <h4 class="text-lg font-bold text-green-600 mb-2">Dashboard Dosen</h4>
                                <p class="text-sm text-gray-600">Lihat jadwal dan rekap absensi</p>
                            </a>
                        @endif

                        @if(auth()->user()->isMahasiswa())
                            <a href="{{ route('mahasiswa.dashboard') }}" class="block p-6 bg-purple-50 hover:bg-purple-100 rounded-lg transition">
                                <h4 class="text-lg font-bold text-purple-600 mb-2">Dashboard Mahasiswa</h4>
                                <p class="text-sm text-gray-600">Absen dan lihat jadwal kuliah</p>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection