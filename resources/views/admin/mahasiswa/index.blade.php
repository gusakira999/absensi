@extends('layouts.app')

@section('title', 'Daftar Mahasiswa')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Mahasiswa</h1>
        <a href="{{ route('admin.mahasiswa.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            + Tambah Mahasiswa
        </a>
    </div>

    {{-- Flash Message Success --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
            <strong>Berhasil!</strong> {{ session('success') }}
        </div>
    @endif

    {{-- Flash Message Error --}}
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
            <strong>Error!</strong> {{ session('error') }}
        </div>
    @endif

    {{-- Search Form --}}
    <div class="bg-white rounded-lg shadow p-4 mb-4">
        <form action="{{ route('admin.mahasiswa.index') }}" method="GET">
            <div class="flex gap-2">
                <input type="text" name="search" value="{{ $search ?? '' }}" 
                       placeholder="Cari nama, NIM, atau email..." 
                       class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition">
                    Cari
                </button>
                @if($search ?? '')
                    <a href="{{ route('admin.mahasiswa.index') }}" 
                       class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Tabel Data --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Angkatan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jurusan</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($mahasiswas as $index => $mhs)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $mahasiswas->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $mhs->nim }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $mhs->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $mhs->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $mhs->angkatan }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $mhs->jurusan }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <a href="{{ route('admin.mahasiswa.edit', $mhs->id) }}" 
                               class="text-blue-600 hover:text-blue-900 mr-3">
                                Edit
                            </a>
                            <form action="{{ route('admin.mahasiswa.destroy', $mhs->id) }}" 
                                  method="POST" class="inline" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa {{ $mhs->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                            </svg>
                            <p class="text-lg">Tidak ada data mahasiswa</p>
                            <p class="text-sm mt-1">Klik tombol "Tambah Mahasiswa" untuk menambahkan data baru</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($mahasiswas->hasPages())
        <div class="mt-4">
            {{ $mahasiswas->links() }}
        </div>
    @endif
</div>
@endsection