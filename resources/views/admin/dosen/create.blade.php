@extends('layouts.app')

@section('title', 'Tambah Dosen')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Dosen</h1>
        <p class="text-gray-600 mt-1">Isi form berikut untuk menambahkan dosen baru</p>
    </div>

    {{-- Form --}}
    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form action="{{ route('admin.dosen.store') }}" method="POST">
            @csrf

            {{-- NIDN --}}
            <div class="mb-4">
                <label for="nidn" class="block text-sm font-medium text-gray-700 mb-2">
                    NIDN <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nidn" name="nidn" value="{{ old('nidn') }}" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nidn') border-red-500 @enderror" 
                       placeholder="Contoh: 0123456789" required>
                @error('nidn')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Lengkap --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror" 
                       placeholder="Contoh: Dr. Ahmad Wijaya, M.Kom" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" 
                       placeholder="Contoh: ahmad@example.com" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password <span class="text-red-500">*</span>
                </label>
                <input type="password" id="password" name="password" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror" 
                       placeholder="Minimal 6 karakter" required>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Konfirmasi Password <span class="text-red-500">*</span>
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="Ulangi password" required>
            </div>

            {{-- Program Studi --}}
            <div class="mb-6">
                <label for="program_studi" class="block text-sm font-medium text-gray-700 mb-2">
                    Program Studi <span class="text-red-500">*</span>
                </label>
                <input type="text" id="program_studi" name="program_studi" value="{{ old('program_studi') }}" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('program_studi') border-red-500 @enderror" 
                       placeholder="Contoh: Teknik Informatika" required>
                @error('program_studi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Simpan
                </button>
                <a href="{{ route('admin.dosen.index') }}" 
                   class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection