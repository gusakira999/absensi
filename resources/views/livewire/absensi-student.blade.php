<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold">Absensi Mahasiswa</h1>
            <p class="text-sm text-zinc-500">Tanggal: {{ \Carbon\Carbon::today()->format('d M Y') }}</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
        <div class="flex items-center gap-3 flex-wrap">
            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Status</label>
            <select wire:model="status" class="px-3 py-2 border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-gray-800 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="hadir">Hadir</option>
                <option value="izin">Izin</option>
                <option value="sakit">Sakit</option>
                <option value="alpha">Alpha</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
        <table class="w-full text-sm text-zinc-900 dark:text-zinc-100">
            <thead class="bg-zinc-100 dark:bg-zinc-800 border-b">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Course</th>
                    <th class="px-6 py-3 text-left font-semibold">Jam</th>
                    <th class="px-6 py-3 text-left font-semibold">Ruang</th>
                    <th class="px-6 py-3 text-left font-semibold">Status Hari Ini</th>
                    <th class="px-6 py-3 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($schedules as $s)
                    @php
                        $courseId = $s->course_id;
                        $att = $attendances->get($courseId);
                    @endphp
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700">
                        <td class="px-6 py-4">
                            <div class="font-medium">{{ $s->course?->course_name }}</div>
                            <div class="text-xs text-zinc-500">{{ $s->course?->course_code }}</div>
                        </td>
                        <td class="px-6 py-4">{{ $s->start_time }} - {{ $s->end_time }}</td>
                        <td class="px-6 py-4">{{ $s->room }}</td>
                        <td class="px-6 py-4">
                            @if($att)
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200">
                                    {{ $att->status }}
                                </span>
                                <div class="text-[11px] text-zinc-500 mt-1">Check-in: {{ optional($att->check_in_time)->format('H:i') }}</div>
                            @else
                                <span class="text-xs text-zinc-500">Belum absen</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button
                                type="button"
                                wire:click="checkIn({{ $s->id }})"
                                class="px-4 py-2 text-sm bg-indigo-600 text-white rounded hover:bg-indigo-700 transition"
                            >
                                {{ $att ? 'Update' : 'Absen' }}
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">Tidak ada jadwal hari ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $schedules->links() }}
    </div>
</div>

