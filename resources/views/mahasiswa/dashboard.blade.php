@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Halo, {{ auth()->user()->name }}!</h3>
                    <p class="mb-4">Kamu login sebagai <span class="font-bold text-purple-600">Mahasiswa</span></p>

                    <div class="mt-6">
                        <h4 class="text-lg font-semibold mb-2">Menu Mahasiswa:</h4>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Lihat Jadwal Kuliah</li>
                            <li>Absen Kehadiran</li>
                            <li>Lihat Riwayat Absensi</li>
                            <li>Lihat Persentase Kehadiran</li>
                        </ul>
                    </div>

                    <div class="mt-6 p-4 bg-purple-50 rounded-lg">
                        <p class="text-sm text-purple-800">
                            <strong>Info:</strong> Fitur absensi akan ditambahkan di Sprint 4
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection