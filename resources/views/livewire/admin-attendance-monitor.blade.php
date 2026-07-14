<div class="space-y-6">
    <div class="space-y-1">
        <h1 class="text-2xl font-semibold">Monitoring Kehadiran</h1>
        <p class="text-sm text-zinc-600">Pantau dan filter seluruh data absensi mahasiswa.</p>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <div class="p-4 rounded-lg bg-white shadow-sm border border-zinc-200">
            <div class="text-sm text-zinc-500">Total Record</div>
            <div class="text-2xl font-semibold">{{ number_format($stats['total']) }}</div>
        </div>
        <div class="p-4 rounded-lg bg-white shadow-sm border border-zinc-200">
            <div class="text-sm text-zinc-500">Hadir</div>
            <div class="text-2xl font-semibold text-emerald-600">{{ number_format($stats['hadir']) }}</div>
        </div>
        <div class="p-4 rounded-lg bg-white shadow-sm border border-zinc-200">
            <div class="text-sm text-zinc-500">Izin</div>
            <div class="text-2xl font-semibold text-amber-600">{{ number_format($stats['izin']) }}</div>
        </div>
        <div class="p-4 rounded-lg bg-white shadow-sm border border-zinc-200">
            <div class="text-sm text-zinc-500">Sakit</div>
            <div class="text-2xl font-semibold text-blue-600">{{ number_format($stats['sakit']) }}</div>
        </div>
        <div class="p-4 rounded-lg bg-white shadow-sm border border-zinc-200">
            <div class="text-sm text-zinc-500">Alpha</div>
            <div class="text-2xl font-semibold text-red-600">{{ number_format($stats['alpha']) }}</div>
        </div>
        <div class="p-4 rounded-lg bg-white shadow-sm border border-zinc-200">
            <div class="text-sm text-zinc-500">% Hadir</div>
            <div class="text-2xl font-semibold">{{ $stats['presencePct'] }}%</div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="p-4 rounded-lg bg-white shadow-sm border border-zinc-200">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
            <div>
                <label class="block text-xs font-medium text-zinc-600 mb-1">Dari Tanggal</label>
                <input
                    type="date"
                    wire:model.live="dateFrom"
                    class="w-full px-3 py-2 border border-zinc-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                />
            </div>
            <div>
                <label class="block text-xs font-medium text-zinc-600 mb-1">Sampai Tanggal</label>
                <input
                    type="date"
                    wire:model.live="dateTo"
                    class="w-full px-3 py-2 border border-zinc-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                />
            </div>
            <div>
                <label class="block text-xs font-medium text-zinc-600 mb-1">Mata Kuliah</label>
                <select
                    wire:model.live="courseId"
                    class="w-full px-3 py-2 border border-zinc-300 bg-white rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                    <option value="0">Semua Mata Kuliah</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->course_code }} — {{ $course->course_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-zinc-600 mb-1">Status</label>
                <select
                    wire:model.live="statusFilter"
                    class="w-full px-3 py-2 border border-zinc-300 bg-white rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                    <option value="">Semua Status</option>
                    <option value="hadir">Hadir</option>
                    <option value="izin">Izin</option>
                    <option value="sakit">Sakit</option>
                    <option value="alpha">Alpha</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-medium text-zinc-600 mb-1">Cari Mahasiswa</label>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="searchTerm"
                    placeholder="Nama, email, atau NIM..."
                    class="w-full px-3 py-2 border border-zinc-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                />
            </div>
        </div>

        <div class="mt-4 flex justify-end">
            <button
                type="button"
                wire:click="resetFilters"
                class="px-4 py-2 text-sm border border-zinc-300 rounded-lg text-zinc-700 hover:bg-zinc-50 transition"
            >
                Reset Filter
            </button>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow-sm border border-zinc-200">
        <table class="w-full text-sm text-zinc-900">
            <thead class="bg-zinc-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Tanggal</th>
                    <th class="px-6 py-3 text-left font-semibold">Mahasiswa</th>
                    <th class="px-6 py-3 text-left font-semibold">Mata Kuliah</th>
                    <th class="px-6 py-3 text-left font-semibold">Status</th>
                    <th class="px-6 py-3 text-left font-semibold">Check-in</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($attendances as $attendance)
                    @php
                        $statusColors = [
                            'hadir' => 'bg-emerald-100 text-emerald-700',
                            'izin' => 'bg-amber-100 text-amber-700',
                            'sakit' => 'bg-blue-100 text-blue-700',
                            'alpha' => 'bg-red-100 text-red-700',
                        ];
                        $color = $statusColors[$attendance->status] ?? 'bg-zinc-100 text-zinc-700';
                    @endphp
                    <tr class="hover:bg-zinc-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium">{{ $attendance->student?->name ?? '-' }}</div>
                            <div class="text-xs text-zinc-500">{{ $attendance->student?->nim ?? $attendance->student?->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium">{{ $attendance->course?->course_name ?? '-' }}</div>
                            <div class="text-xs text-zinc-500">{{ $attendance->course?->course_code }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $color }}">
                                {{ ucfirst($attendance->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if ($attendance->check_in_time)
                                {{ \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i') }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-zinc-500">
                            Tidak ada data absensi untuk filter yang dipilih.
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
