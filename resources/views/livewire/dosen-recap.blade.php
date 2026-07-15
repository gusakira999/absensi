<div class="space-y-6">
    {{-- Header + Filter --}}
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-2xl font-semibold">Rekap Absensi</h1>
            <p class="text-sm text-zinc-500">Data absensi mahasiswa pada jadwal Anda.</p>
        </div>

        <div class="flex items-center gap-3 flex-wrap">
            {{-- Filter Tanggal --}}
            <div>
                <label class="block text-xs font-medium text-zinc-600 mb-1">Tanggal</label>
                <input type="date" wire:model.live="date"
                    class="px-3 py-2 border border-zinc-300 bg-white dark:bg-gray-800 dark:border-zinc-600 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>

            {{-- Filter Status --}}
            <div>
                <label class="block text-xs font-medium text-zinc-600 mb-1">Filter Status</label>
                <select wire:model.live="statusFilter"
                    class="px-3 py-2 border border-zinc-300 bg-white dark:bg-gray-800 dark:border-zinc-600 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua</option>
                    <option value="hadir">Hadir</option>
                    <option value="izin">Izin</option>
                    <option value="sakit">Sakit</option>
                    <option value="alpha">Alpha</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Stat Cards --}}
    @php
        $totalAtt   = $attendances->total();
        $hadirCount = $attendances->getCollection()->where('status','hadir')->count();
        $izinCount  = $attendances->getCollection()->where('status','izin')->count();
        $sakitCount = $attendances->getCollection()->where('status','sakit')->count();
        $alphaCount = $attendances->getCollection()->where('status','alpha')->count();
    @endphp
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border-l-4 border-green-500">
            <p class="text-xs text-zinc-500 uppercase tracking-wide">Hadir</p>
            <p class="text-2xl font-bold text-green-600">{{ $hadirCount }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border-l-4 border-yellow-500">
            <p class="text-xs text-zinc-500 uppercase tracking-wide">Izin</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $izinCount }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border-l-4 border-blue-500">
            <p class="text-xs text-zinc-500 uppercase tracking-wide">Sakit</p>
            <p class="text-2xl font-bold text-blue-600">{{ $sakitCount }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border-l-4 border-red-500">
            <p class="text-xs text-zinc-500 uppercase tracking-wide">Alpha</p>
            <p class="text-2xl font-bold text-red-600">{{ $alphaCount }}</p>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
        <table class="w-full text-sm text-zinc-900 dark:text-zinc-100">
            <thead class="bg-zinc-100 dark:bg-zinc-700 border-b">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Mata Kuliah</th>
                    <th class="px-6 py-3 text-left font-semibold">Mahasiswa</th>
                    <th class="px-6 py-3 text-left font-semibold">Status</th>
                    <th class="px-6 py-3 text-left font-semibold">Check-in</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                @forelse($attendances as $a)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700">
                        <td class="px-6 py-4">
                            <div class="font-medium">{{ $a->course?->course_name ?? '-' }}</div>
                            <div class="text-xs text-zinc-500">{{ $a->course?->course_code }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium">{{ $a->student?->name ?? '-' }}</div>
                            <div class="text-xs text-zinc-500">{{ $a->student?->nim ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $badgeClass = match($a->status) {
                                    'hadir' => 'bg-green-100 text-green-700',
                                    'izin'  => 'bg-yellow-100 text-yellow-700',
                                    'sakit' => 'bg-blue-100 text-blue-700',
                                    'alpha' => 'bg-red-100 text-red-700',
                                    default => 'bg-zinc-100 text-zinc-700',
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $badgeClass }}">
                                {{ ucfirst($a->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-zinc-600 dark:text-zinc-300">
                            {{ optional($a->check_in_time)->format('H:i') ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-zinc-500 dark:text-zinc-400">
                            <div class="text-4xl mb-2">📭</div>
                            <div>Belum ada data absensi untuk tanggal <strong>{{ $date }}</strong>.</div>
                            @if($schedules->isEmpty())
                                <div class="text-xs mt-1 text-zinc-400">Anda tidak memiliki jadwal pada hari ini.</div>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $attendances->links() }}
    </div>
</div>
