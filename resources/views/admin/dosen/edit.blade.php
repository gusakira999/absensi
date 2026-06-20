@extends('layouts.app')

@section('title', 'Edit Dosen')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Dosen</h1>
        <p class="text-gray-600 mt-1">Ubah data dosen {{ $dosen->name }}</p>
    </div>

    {{-- Form --}}
    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form action="{{ route('admin.dosen.update', $dosen->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- NIDN --}}
            <div class="mb-4">
                <label for="nidn" class="block text-sm font-medium text-gray-700 mb-2">
                    NIDN <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nidn" name="nidn" value="{{ old('nidn', $dosen->nidn) }}" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nidn') border-red-500 @enderror" 
                       required>
                @error('nidn')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Lengkap --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $dosen->name) }}" 
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
                <input type="email" id="email" name="email" value="{{ old('email', $dosen->email) }}" 
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

                       {{-- Program Studi --}}
            <div class="mb-6">
                <label for="program_studi" class="block text-sm font-medium text-gray-700 mb-2">
                    Program Studi <span class="text-red-500">*</span>
                </label>
                <input type="text" id="program_studi" name="program_studi" value="{{ old('program_studi', $dosen->program_studi) }}" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('program_studi') border-red-500 @enderror" 
                       required>
                @error('program_studi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- TOMBOL SIMPAN DAN BATAL --}}
            <div class="flex gap-3 pt-4 border-t border-gray-200 mt-6">
                <flux:button type="submit" variant="primary">
                     UPDATE DATA
                </flux:button>
    
                 <flux:button href="{{ route('admin.dosen.index') }}" variant="outline">
                     BATAL
                </flux:button>
            </div>

        </form>
    </div>
</div>
@endsection