<x-layouts::app.sidebar :title="__('Dashboard Mahasiswa')">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">Dashboard Mahasiswa</h1>
                <p class="text-sm text-zinc-500">Ringkasan kehadiran & aktivitas hari ini</p>
            </div>
        </div>

        {{-- (1) Stat Cards + rincian status --}}
        @php
            $att = auth()->user()?->attendances();
            $today = \Carbon\Carbon::today();

            // Ambil presensi hari ini dari relasi Attendance (kalau ada), kalau tidak fallback query
            $todayAttendances = $att
                ? $att->whereDate('attendance_date', $today->toDateString())->get()
                : \App\Models\Attendance::query()->where('user_id', auth()->id())->whereDate('attendance_date', $today->toDateString())->get();

            $total = $todayAttendances->count();

            $countHadir = $todayAttendances->where('status', 'hadir')->count();
            $countIzin = $todayAttendances->where('status', 'izin')->count();
            $countSakit = $todayAttendances->where('status', 'sakit')->count();
            $countAlpha = $todayAttendances->where('status', 'alpha')->count();

            $persen = $total > 0 ? round(($countHadir / $total) * 100) : 0;
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="text-sm text-zinc-500">Persentase Hadir</div>
                <div class="text-2xl font-semibold">{{ $persen }}%</div>
                <div class="mt-2 text-xs text-zinc-500">dari {{ $total }} presensi hari ini</div>
            </div>

            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="text-sm text-zinc-500">Status</div>
                <div class="mt-2 space-y-1 text-sm">
                    <div class="flex items-center justify-between"><span class="text-zinc-600">Hadir</span><span class="font-medium">{{ $countHadir }}</span></div>
                    <div class="flex items-center justify-between"><span class="text-zinc-600">Izin</span><span class="font-medium">{{ $countIzin }}</span></div>
                    <div class="flex items-center justify-between"><span class="text-zinc-600">Sakit</span><span class="font-medium">{{ $countSakit }}</span></div>
                    <div class="flex items-center justify-between"><span class="text-zinc-600">Alpha</span><span class="font-medium">{{ $countAlpha }}</span></div>
                </div>
            </div>


        </div>

        {{-- (2) Jadwal Hari Ini + tombol Absen Sekarang --}}
        @php
            $today = \Carbon\Carbon::today();
            $dayMap = [
                1 => 'mon',
                2 => 'tue',
                3 => 'wed',
                4 => 'thu',
                5 => 'fri',
                6 => 'sat',
                0 => 'sun',
            ];
            $dayKey = $dayMap[$today->dayOfWeek] ?? 'mon';

            $schedulesToday = \App\Models\Schedule::query()
                ->where('day', $dayKey)
                ->with(['course'])
                ->orderBy('start_time')
                ->get();

            $scheduleNow = $schedulesToday->first(function($s) use ($today) {
                $now = \Carbon\Carbon::now();
                $start = \Carbon\Carbon::parse($today->toDateString().' '.$s->start_time);
                $end = \Carbon\Carbon::parse($today->toDateString().' '.$s->end_time);
                return $now->greaterThanOrEqualTo($start) && $now->lessThanOrEqualTo($end);
            });
        @endphp

        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold">📅 Jadwal Hari Ini</h2>
                    <p class="text-sm text-zinc-500">{{ $today->format('d M Y') }}</p>
                </div>

                <div class="flex items-center gap-3">
                    @if($scheduleNow)
                        <button
                            type="button"
                            class="px-4 py-2 text-sm bg-indigo-600 text-white rounded hover:bg-indigo-700 transition"
                            disabled
                        >
                            Absen Sekarang
                        </button>
                        <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-700">Sedang jam kuliah</span>
                    @else
                        <button
                            type="button"
                            disabled
                            class="px-4 py-2 text-sm bg-zinc-200 dark:bg-zinc-700 text-zinc-500 rounded cursor-not-allowed"
                        >
                            Absen Sekarang
                        </button>
                        <span class="text-xs px-2 py-1 rounded-full bg-zinc-100 text-zinc-600">Belum jam</span>
                    @endif
                </div>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left">
                        <tr class="border-b border-zinc-200 dark:border-zinc-700">
                            <th class="py-2">Mata Kuliah</th>
                            <th class="py-2">Jam</th>
                            <th class="py-2">Ruang</th>
                            <th class="py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedulesToday as $s)
                            <tr class="border-b border-zinc-100 dark:border-zinc-800">
                                <td class="py-2">
                                    <div class="font-medium">{{ $s->course?->course_name }}</div>
                                    <div class="text-xs text-zinc-500">{{ $s->course?->course_code }}</div>
                                </td>
                                <td class="py-2">{{ $s->start_time }} - {{ $s->end_time }}</td>
                                <td class="py-2">{{ $s->room }}</td>
                                <td class="py-2 text-zinc-600">{{ $s->id === ($scheduleNow?->id) ? 'Aktif' : 'Belum' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-6 text-center text-zinc-500">Tidak ada jadwal hari ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- (3) Riwayat Absensi Terkini (3-5 entri) --}}
        @php
            $recentAttendances = \App\Models\Attendance::query()
                ->where('user_id', auth()->id())
                ->orderBy('attendance_date', 'desc')
                ->orderBy('check_in_time', 'desc')
                ->limit(5)
                ->get();
        @endphp

        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold">🕒 Riwayat Absensi Terkini</h2>
            </div>

            <div class="mt-3 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left">
                        <tr class="border-b border-zinc-200 dark:border-zinc-700">
                            <th class="py-2">Tanggal</th>
                            <th class="py-2">Mata Kuliah</th>
                            <th class="py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentAttendances as $a)
                            <tr class="border-b border-zinc-100 dark:border-zinc-800">
                                <td class="py-2">{{ \Carbon\Carbon::parse($a->attendance_date)->format('d M Y') }}</td>
                                <td class="py-2">{{ $a->course?->course_name ?? ('Course #'.$a->course_id) }}</td>
                                <td class="py-2">
                                    <span class="text-xs px-3 py-1 rounded-full bg-blue-100 text-blue-700">{{ $a->status }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="py-6 text-center text-zinc-500">Belum ada riwayat absensi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


    </div>
</x-layouts::app.sidebar>


