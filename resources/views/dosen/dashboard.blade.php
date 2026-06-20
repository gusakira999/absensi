<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Dosen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Halo, {{ auth()->user()->name }}!</h3>
                    <p class="mb-4">Kamu login sebagai <span class="font-bold text-green-600">Dosen</span></p>
                    
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold mb-2">Menu Dosen:</h4>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Lihat Jadwal Mengajar</li>
                            <li>Generate QR Code Absensi</li>
                            <li>Lihat Rekap Kehadiran Mahasiswa</li>
                            <li>Export Laporan ke PDF</li>
                        </ul>
                    </div>

                    <div class="mt-6 p-4 bg-green-50 rounded-lg">
                        <p class="text-sm text-green-800">
                            <strong>Info:</strong> Fitur absensi akan ditambahkan di Sprint 4
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<x-layouts.app>