<div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-zinc-900">Mata Kuliah</h1>
                <p class="text-sm text-zinc-500 mt-1">Kelola daftar mata kuliah yang tersedia</p>
            </div>
            <button 
                wire:click="openCreateForm"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition"
            >
                + Tambah Mata Kuliah
            </button>
        </div>

        <!-- Search -->
        <div class="mb-6">
            <input 
                type="text" 
                wire:model.live="searchTerm" 
                placeholder="Cari nama course, kode, atau dosen..."
                class="w-full px-4 py-2 border border-zinc-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>

        <!-- Table -->
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="w-full text-sm">
                <thead class="bg-zinc-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold">Kode Course</th>
                        <th class="px-6 py-3 text-left font-semibold">Nama Course</th>
                        <th class="px-6 py-3 text-left font-semibold">Dosen</th>
                        <th class="px-6 py-3 text-left font-semibold">Semester</th>
                        <th class="px-6 py-3 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($courses as $course)
                        <tr class="hover:bg-zinc-50">
                            <td class="px-6 py-4 font-mono text-blue-600">{{ $course->course_code }}</td>
                            <td class="px-6 py-4">{{ $course->course_name }}</td>
                            <td class="px-6 py-4">{{ $course->lecturer }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                                    Semester {{ $course->semester }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <button 
                                    wire:click="openEditForm({{ $course->id }})"
                                    class="px-3 py-1 text-sm bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200 transition"
                                >
                                    Edit
                                </button>
                                <button 
                                    wire:click="delete({{ $course->id }})"
                                    wire:confirm="Apakah Anda yakin ingin menghapus course ini?"
                                    class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded hover:bg-red-200 transition"
                                >
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-zinc-500">
                                Tidak ada mata kuliah ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $courses->links() }}
        </div>

        <!-- Modal Form -->
        @if($showForm)
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                    <div class="px-6 py-4 border-b flex justify-between items-center">
                        <h2 class="text-xl font-bold">
                            @if($editingId)
                                Edit Mata Kuliah
                            @else
                                Tambah Mata Kuliah Baru
                            @endif
                        </h2>
                        <button 
                            wire:click="closeForm"
                            class="text-gray-500 hover:text-gray-700"
                        >
                            ✕
                        </button>
                    </div>

                    <form wire:submit="save" class="p-6 space-y-4">
                        <!-- Course Name -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 mb-1">
                                Nama Mata Kuliah
                            </label>
                            <input 
                                type="text" 
                                wire:model.defer="course_name" 
                                class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Contoh: Pemrograman Web"
                            >
                            @error('course_name')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Course Code -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 mb-1">
                                Kode Mata Kuliah
                            </label>
                            <input 
                                type="text" 
                                wire:model.defer="course_code" 
                                class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Contoh: CS301"
                            >
                            @error('course_code')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Lecturer -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 mb-1">
                                Nama Dosen
                            </label>
                            <input 
                                type="text" 
                                wire:model.defer="lecturer" 
                                class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Contoh: Dr. Budi Santoso"
                            >
                            @error('lecturer')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Semester -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 mb-1">
                                Semester
                            </label>
                            <select 
                                wire:model.defer="semester" 
                                class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                <option value="">-- Pilih Semester --</option>
                                @for($i = 1; $i <= 8; $i++)
                                    <option value="{{ $i }}">Semester {{ $i }}</option>
                                @endfor
                            </select>
                            @error('semester')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-3 pt-4">
                            <button 
                                type="button"
                                wire:click="closeForm"
                                class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium"
                            >
                                Batal
                            </button>
                            <button 
                                type="submit"
                                class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium"
                            >
                                @if($editingId)
                                    Perbarui
                                @else
                                    Tambahkan
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
