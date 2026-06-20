@extends('layouts.app')

@section('title', 'Edit Mahasiswa')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Mahasiswa</h1>
        <p class="text-gray-600 mt-1">Ubah data mahasiswa {{ $mahasiswa->name }}</p>
    </div>

    {{-- Form --}}
    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form action="{{ route('admin.mahasiswa.update', $mahasiswa->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- NIM --}}
            <div class="mb-4">
                <label for="nim" class="block text-sm font-medium text-gray-700 mb-2">
                    NIM <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nim" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nim') border-red-500 @enderror" 
                       required>
                @error('nim')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Lengkap --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $mahasiswa->name) }}" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror" 
                       required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" id="email" name="email" value="{{ old('email', $mahasiswa->email) }}" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" 
                       required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password Baru <span class="text-gray-400 text-xs">(kosongkan jika tidak diubah)</span>
                </label>
                <input type="password" id="password" name="password" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror" 
                       placeholder="Minimal 6 karakter">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Konfirmasi Password Baru
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="Ulangi password baru">
            </div>

            {{-- Angkatan --}}
            <div class="mb-4">
                <label for="angkatan" class="block text-sm font-medium text-gray-700 mb-2">
                    Angkatan <span class="text-red-500">*</span>
                </label>
                <input type="number" id="angkatan" name="angkatan" value="{{ old('angkatan', $mahasiswa->angkatan) }}" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('angkatan') border-red-500 @enderror" 
                       min="2000" max="2100" required>
                @error('angkatan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jurusan --}}
            <div class="mb-6">
                <label for="jurusan" class="block text-sm font-medium text-gray-700 mb-2">
                    Jurusan <span class="text-red-500">*</span>
                </label>
                <input type="text" id="jurusan" name="jurusan" value="{{ old('jurusan', $mahasiswa->jurusan) }}" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jurusan') border-red-500 @enderror" 
                       required>
                @error('jurusan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.mahasiswa.index') }}" 
                   class="px-6 py-2.5 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition shadow-sm">
                    Batal
                </a>
                
                <button type="submit" 
                        class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition shadow-md">
                    Update Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection