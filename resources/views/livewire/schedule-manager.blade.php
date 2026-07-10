<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold">Manajemen Jadwal</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Kelola jadwal kuliah (Admin)</p>
        </div>

        <button
            wire:click="openCreateForm"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition"
        >
            + Tambah Jadwal
        </button>
    </div>

    <div>
        <input
            type="text"
            wire:model.live.debounce.300ms="searchTerm"
            placeholder="Cari course atau dosen..."
            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-gray-800 text-zinc-900 dark:text-zinc-100 placeholder:text-zinc-400 dark:placeholder:text-zinc-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
    </div>

    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
        <table class="w-full text-sm text-zinc-900 dark:text-zinc-100">
            <thead class="bg-zinc-100 dark:bg-zinc-800 border-b">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Course</th>
                    <th class="px-6 py-3 text-left font-semibold">Dosen</th>
                    <th class="px-6 py-3 text-left font-semibold">Hari</th>
                    <th class="px-6 py-3 text-left font-semibold">Jam</th>
                    <th class="px-6 py-3 text-left font-semibold">Ruang</th>
                    <th class="px-6 py-3 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($schedules as $s)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700">
                        <td class="px-6 py-4">
                            <div class="font-medium">{{ $s->course?->course_name }}</div>
                            <div class="text-xs text-zinc-500">{{ $s->course?->course_code }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium">{{ $s->lecturerUser?->name }}</div>
                            <div class="text-xs text-zinc-500">{{ $s->lecturerUser?->email }}</div>
                        </td>
                        <td class="px-6 py-4">{{ $s->day }}</td>
                        <td class="px-6 py-4">{{ $s->start_time }} - {{ $s->end_time }}</td>
                        <td class="px-6 py-4">{{ $s->room }}</td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <button
                                wire:click="openEditForm({{ $s->id }})"
                                class="px-3 py-1 text-sm bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-200 rounded hover:bg-yellow-200 dark:hover:bg-yellow-800 transition"
                            >Edit</button>
                            <button
                                wire:click="delete({{ $s->id }})"
                                wire:confirm="Yakin hapus jadwal ini?"
                                class="px-3 py-1 text-sm bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 rounded hover:bg-red-200 dark:hover:bg-red-800 transition"
                            >Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">Belum ada jadwal.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $schedules->links() }}
    </div>

    @if($showForm)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4">
                <div class="px-6 py-4 border-b flex justify-between items-center">
                    <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">
                        {{ $editingId ? '✏️ Edit Jadwal' : '➕ Tambah Jadwal' }}
                    </h2>
                    <button wire:click="closeForm" class="text-gray-500 dark:text-zinc-300 hover:text-gray-700 dark:hover:text-gray-400 text-2xl">✕</button>
                </div>

                <form wire:submit.prevent="save" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200 mb-1">Course</label>
                        <select wire:model.defer="course_id" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Course --</option>
                            @foreach($courses as $c)
                                <option value="{{ $c->id }}">{{ $c->course_code }} - {{ $c->course_name }}</option>
                            @endforeach
                        </select>
                        @error('course_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200 mb-1">Dosen</label>
                        <select wire:model.defer="user_id" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Dosen --</option>
                            @foreach($dosens as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200 mb-1">Hari</label>
                        <select wire:model.defer="dayInput" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Hari --</option>
                            <option value="mon">Senin</option>
                            <option value="tue">Selasa</option>
                            <option value="wed">Rabu</option>
                            <option value="thu">Kamis</option>
                            <option value="fri">Jumat</option>
                            <option value="sat">Sabtu</option>
                            <option value="sun">Minggu</option>
                        </select>
                        @error('dayInput') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200 mb-1">Mulai</label>
                            <input type="time" wire:model.defer="start_time" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('start_time') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200 mb-1">Selesai</label>
                            <input type="time" wire:model.defer="end_time" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('end_time') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200 mb-1">Ruang</label>
                        <input type="text" wire:model.defer="room" placeholder="Contoh: Lab 1" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        @error('room') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" wire:click="closeForm" class="flex-1 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-zinc-100 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition font-medium">Batal</button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

