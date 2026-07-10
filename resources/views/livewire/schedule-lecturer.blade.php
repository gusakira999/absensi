<div class="space-y-4">
    <h1 class="text-2xl font-semibold">Jadwal Anda</h1>
    <p class="text-sm text-zinc-500 dark:text-zinc-400">Berikut jadwal yang Anda ajarkan.</p>

    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
        <table class="w-full text-sm text-zinc-900 dark:text-zinc-100">
            <thead class="bg-zinc-100 dark:bg-zinc-800 border-b">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Course</th>
                    <th class="px-6 py-3 text-left font-semibold">Hari</th>
                    <th class="px-6 py-3 text-left font-semibold">Jam</th>
                    <th class="px-6 py-3 text-left font-semibold">Ruang</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($schedules as $s)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700">
                        <td class="px-6 py-4">
                            <div class="font-medium">{{ $s->course?->course_name }}</div>
                            <div class="text-xs text-zinc-500">{{ $s->course?->course_code }}</div>
                        </td>
                        <td class="px-6 py-4">{{ $s->day }}</td>
                        <td class="px-6 py-4">{{ $s->start_time }} - {{ $s->end_time }}</td>
                        <td class="px-6 py-4">{{ $s->room }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">Belum ada jadwal.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $schedules->links() }}
</div>

