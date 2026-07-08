<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">Manajemen User</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Kelola data dosen dan mahasiswa</p>
        </div>
    </div>

    <!-- Search -->
    <div class="mb-6">
        <input
            type="text"
            wire:model.live.debounce.300ms="searchTerm"
            placeholder="Cari nama, email, atau NIM..."
            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-gray-800 text-zinc-900 dark:text-zinc-100 placeholder:text-zinc-400 dark:placeholder:text-zinc-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
    </div>

    <!-- Tabs Navigation -->
    <div class="flex gap-2 border-b border-zinc-300 dark:border-zinc-700">
        <button 
            wire:click="$set('selectedRole', 'dosen')"
            class="px-6 py-3 font-semibold transition {{ $selectedRole === 'dosen' ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400' : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-300' }}"
        >
            👨‍🏫 Dosen
        </button>
        <button 
            wire:click="$set('selectedRole', 'mahasiswa')"
            class="px-6 py-3 font-semibold transition {{ $selectedRole === 'mahasiswa' ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400' : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-300' }}"
        >
            👨‍🎓 Mahasiswa
        </button>
    </div>

    <!-- TAB: DOSEN -->
    @if($selectedRole === 'dosen')
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                    📋 Daftar Dosen ({{ $dosens->total() }})
                </h2>
                <button 
                    wire:click="openCreateForm('dosen')"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition"
                >
                    + Tambah Dosen
                </button>
            </div>

            <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
                <table class="w-full text-sm text-zinc-900 dark:text-zinc-100">
                    <thead class="bg-zinc-100 dark:bg-zinc-800 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold">Nama</th>
                            <th class="px-6 py-3 text-left font-semibold">Email</th>
                            <th class="px-6 py-3 text-left font-semibold">Bergabung</th>
                            <th class="px-6 py-3 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($dosens as $dosen)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700 transition">
                                <td class="px-6 py-4 font-medium">{{ $dosen->name }}</td>
                                <td class="px-6 py-4">{{ $dosen->email }}</td>
                                <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400 text-xs">
                                    {{ $dosen->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-center space-x-2">
                                    <button
                                        wire:click="openEditForm({{ $dosen->id }})"
                                        class="px-3 py-1 text-sm bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-200 rounded hover:bg-yellow-200 dark:hover:bg-yellow-800 transition"
                                    >Edit</button>

                                    <button
                                        wire:click="delete({{ $dosen->id }})"
                                        wire:confirm="Yakin hapus dosen ini?"
                                        class="px-3 py-1 text-sm bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 rounded hover:bg-red-200 dark:hover:bg-red-800 transition"
                                    >Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                    Tidak ada data dosen ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $dosens->links() }}
            </div>
        </div>
    @endif

    <!-- TAB: MAHASISWA -->
    @if($selectedRole === 'mahasiswa')
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                    📋 Daftar Mahasiswa ({{ $mahasiswas->total() }})
                </h2>
                <button 
                    wire:click="openCreateForm('mahasiswa')"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition"
                >
                    + Tambah Mahasiswa
                </button>
            </div>

            <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
                <table class="w-full text-sm text-zinc-900 dark:text-zinc-100">
                    <thead class="bg-zinc-100 dark:bg-zinc-800 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold">Nama</th>
                            <th class="px-6 py-3 text-left font-semibold">Email</th>
                            <th class="px-6 py-3 text-left font-semibold">NIM</th>
                            <th class="px-6 py-3 text-left font-semibold">Bergabung</th>
                            <th class="px-6 py-3 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($mahasiswas as $mahasiswa)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700 transition">
                                <td class="px-6 py-4 font-medium">{{ $mahasiswa->name }}</td>
                                <td class="px-6 py-4">{{ $mahasiswa->email }}</td>
                                <td class="px-6 py-4 font-mono text-blue-600 dark:text-blue-400">
                                    {{ $mahasiswa->nim ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400 text-xs">
                                    {{ $mahasiswa->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-center space-x-2">
                                    <button
                                        wire:click="openEditForm({{ $mahasiswa->id }})"
                                        class="px-3 py-1 text-sm bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-200 rounded hover:bg-yellow-200 dark:hover:bg-yellow-800 transition"
                                    >Edit</button>

                                    <button
                                        wire:click="delete({{ $mahasiswa->id }})"
                                        wire:confirm="Yakin hapus mahasiswa ini?"
                                        class="px-3 py-1 text-sm bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 rounded hover:bg-red-200 dark:hover:bg-red-800 transition"
                                    >Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                    Tidak ada data mahasiswa ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $mahasiswas->links() }}
            </div>
        </div>
    @endif

    <!-- Modal Form -->
    @if($showForm)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4">
                <div class="px-6 py-4 border-b flex justify-between items-center">
                    <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">
                        {{ $editingId ? '✏️ Edit User' : '➕ Tambah User' }}
                    </h2>
                    <button 
                        wire:click="closeForm" 
                        class="text-gray-500 dark:text-zinc-300 hover:text-gray-700 dark:hover:text-gray-400 text-2xl"
                    >✕</button>
                </div>

                <form wire:submit.prevent="save" class="p-6 space-y-4">
                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200 mb-1">Nama</label>
                        <input 
                            type="text" 
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-gray-700 text-zinc-900 dark:text-zinc-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                            wire:model.defer="form.name" 
                            placeholder="Masukkan nama lengkap"
                        />
                        @error('form.name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200 mb-1">Email</label>
                        <input 
                            type="email" 
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-gray-700 text-zinc-900 dark:text-zinc-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                            wire:model.defer="form.email" 
                            placeholder="email@example.com"
                        />
                        @error('form.email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200 mb-1">Role</label>
                        <select 
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-gray-700 text-zinc-900 dark:text-zinc-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                            wire:model.defer="form.role"
                        >
                            <option value="dosen">👨‍🏫 Dosen</option>
                            <option value="mahasiswa">👨‍🎓 Mahasiswa</option>
                        </select>
                        @error('form.role') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- NIM (hanya untuk mahasiswa) -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200 mb-1">
                            NIM <span class="text-xs text-zinc-500">(opsional)</span>
                        </label>
                        <input 
                            type="text" 
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-gray-700 text-zinc-900 dark:text-zinc-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                            wire:model.defer="form.nim" 
                            placeholder="Nomor induk mahasiswa"
                        />
                        @error('form.nim') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200 mb-1">
                            Password {{ $editingId ? '(kosongkan jika tidak diubah)' : '' }}
                        </label>
                        <input 
                            type="password" 
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-gray-700 text-zinc-900 dark:text-zinc-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                            wire:model.defer="form.password" 
                            placeholder="Masukkan password"
                        />
                        @error('form.password') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-4">
                        <button 
                            type="button" 
                            wire:click="closeForm" 
                            class="flex-1 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-zinc-100 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition font-medium"
                        >Batal</button>
                        <button 
                            type="submit" 
                            class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium"
                        >Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
