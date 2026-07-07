<div>
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Manajemen User (Dosen & Mahasiswa)</h1>

        <button wire:click="openCreateForm" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + Tambah
        </button>
    </div>

    <div class="mb-4 flex gap-3">
        <input
            type="text"
            class="border rounded px-3 py-2 w-full"
            placeholder="Cari nama/email/nim/role..."
            wire:model.live.debounce.300ms="searchTerm"
        />
    </div>

    <div class="bg-white shadow rounded p-4">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-left">
                    <tr class="border-b">
                        <th class="py-2">Nama</th>
                        <th class="py-2">Email</th>
                        <th class="py-2">Role</th>
                        <th class="py-2">NIM</th>
                        <th class="py-2 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $u)
                        <tr class="border-b">
                            <td class="py-2">{{ $u->name }}</td>
                            <td class="py-2">{{ $u->email }}</td>
                            <td class="py-2 capitalize">{{ $u->role }}</td>
                            <td class="py-2">{{ $u->nim }}</td>
                            <td class="py-2 text-right">
                                <button
                                    wire:click="openEditForm({{ $u->id }})"
                                    class="px-3 py-1 rounded bg-gray-100 hover:bg-gray-200"
                                >Edit</button>

                                <button
                                    wire:click="delete({{ $u->id }})"
                                    onclick="return confirm('Yakin hapus user ini?')"
                                    class="ml-2 px-3 py-1 rounded bg-red-100 hover:bg-red-200 text-red-700"
                                >Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-3 text-center text-gray-500">Data tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>

    @if($showForm)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center p-4" role="dialog" aria-modal="true">
            <div class="bg-white w-full max-w-xl rounded shadow p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold">{{ $editingId ? 'Edit User' : 'Tambah User' }}</h2>
                    <button wire:click="closeForm" class="px-3 py-1 rounded bg-gray-100 hover:bg-gray-200">Tutup</button>
                </div>

                <form wire:submit.prevent="save" class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium">Nama</label>
                        <input type="text" class="border rounded w-full px-3 py-2" wire:model="form.name" />
                        @error('form.name') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Email</label>
                        <input type="email" class="border rounded w-full px-3 py-2" wire:model="form.email" />
                        @error('form.email') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Role</label>
                        <select class="border rounded w-full px-3 py-2" wire:model="form.role">
                            <option value="dosen">dosen</option>
                            <option value="mahasiswa">mahasiswa</option>
                        </select>
                        @error('form.role') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">NIM (opsional)</label>
                        <input type="text" class="border rounded w-full px-3 py-2" wire:model="form.nim" />
                        @error('form.nim') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Password</label>

                        <input type="password" class="border rounded w-full px-3 py-2" wire:model="form.password" />
                        @error('form.password') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="flex gap-2 pt-2">
                        <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Simpan
                        </button>
                        <button type="button" wire:click="closeForm" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

