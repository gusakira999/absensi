<div class="space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <h1 class="text-2xl font-semibold">Rekap Absensi Dosen</h1>
            <p class="text-sm text-zinc-500">Tanggal: {{ $date }}</p>
        </div>

        <div class="flex items-center gap-3 flex-wrap">
            <div>
                <label class="block text-xs font-medium text-zinc-600 mb-1">Filter Status</label>
                <select wire:model.live="statusFilter" class="px-3 py-2 border border-zinc-300 bg-white rounded-lg text-sm">
                    <option value="">Semua</option>
                    <option value="hadir">Hadir</option>
                    <option value="izin">Izin</option>
                    <option value="sakit">Sakit</option>
                    <option value="alpha">Alpha</option>
                </select>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
        <table class="w-full text-sm text-zinc-900 dark:text-zinc-100">
            <thead class="bg-zinc-100 dark:bg-zinc-800 border-b">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Course</th>
                    <th class="px-6 py-3 text-left font-semibold">Mahasiswa</th>
                    <th class="px-6 py-3 text-left font-semibold">Status</th>
                    <th class="px-6 py-3 text-left font-semibold">Check-in</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($attendances as $a)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700">
                        <td class="px-6 py-4">
                            {{ $a->course?->course_name ?? ($a->course_id ?? '-') }}
                            <div class="text-xs text-zinc-500">{{ $a->course?->course_code }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium">{{ $a->student?->name }}</div>
                            <div class="text-xs text-zinc-500">{{ $a->student?->nim }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-200">
                                {{ $a->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ optional($a->check_in_time)->format('H:i') ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">
                            Belum ada data absensi untuk tanggal ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $attendances->links() }}
    </div>

    @if($schedules->isEmpty())
        <div class="text-sm text-zinc-500">
            Tidak ada jadwal untuk dosen ini pada hari/tanggal yang dipilih.
        </div>
    @endif
</div>

