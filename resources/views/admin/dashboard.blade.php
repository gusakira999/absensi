
{{-- Admin dashboard: dibuat mengikuti theme layout Flux default (Laravel default) --}}
<x-layouts::app.sidebar :title="__('Admin Dashboard')">
    <div class="space-y-6">
        @php
            $totalMahasiswa = \App\Models\User::query()->where('role', 'mahasiswa')->count();
            $totalDosen = \App\Models\User::query()->where('role', 'dosen')->count();
            $totalMataKuliah = \App\Models\Course::query()->count();

            $today = \Carbon\Carbon::today()->toDateString();

            $totalAttendanceToday = \App\Models\Attendance::query()
                ->whereDate('attendance_date', $today)
                ->count();

            $hadirToday = \App\Models\Attendance::query()
                ->whereDate('attendance_date', $today)
                ->where('status', 'hadir')
                ->count();

            $presencePct = $totalAttendanceToday > 0
                ? round(($hadirToday / $totalAttendanceToday) * 100)
                : 0;

            $days = [];
            for ($i = 6; $i >= 0; $i--) {
                $d = \Carbon\Carbon::today()->subDays($i);
                $days[] = $d->toDateString();
            }

            $weekly = collect($days)->map(function ($date) {
                $total = \App\Models\Attendance::query()->whereDate('attendance_date', $date)->count();
                $hadir = \App\Models\Attendance::query()->whereDate('attendance_date', $date)->where('status', 'hadir')->count();
                $pct = $total > 0 ? round(($hadir / $total) * 100) : 0;
                return ['date' => \Carbon\Carbon::parse($date)->format('d M'), 'pct' => $pct];
            });

            $latestActivities = \App\Models\Attendance::query()
                ->with(['student', 'course'])
                ->orderByDesc('created_at')
                ->limit(10)
                ->get();
        @endphp


        <div class="space-y-1">
            <h1 class="text-2xl font-semibold">Admin Dashboard</h1>
            <p class="text-sm text-zinc-600">Ringkasan kondisi kehadiran mahasiswa hari ini.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="p-4 rounded-lg bg-white shadow-sm border border-zinc-200">
                <div class="text-sm text-zinc-500">Total Mahasiswa</div>
                <div class="text-2xl font-semibold">{{ number_format($totalMahasiswa) }}</div>
            </div>
            <div class="p-4 rounded-lg bg-white shadow-sm border border-zinc-200">
                <div class="text-sm text-zinc-500">Total Dosen</div>
                <div class="text-2xl font-semibold">{{ number_format($totalDosen) }}</div>
            </div>
            <div class="p-4 rounded-lg bg-white shadow-sm border border-zinc-200">
                <div class="text-sm text-zinc-500">Total Mata Kuliah</div>
                <div class="text-2xl font-semibold">{{ number_format($totalMataKuliah) }}</div>
            </div>
            <div class="p-4 rounded-lg bg-white shadow-sm border border-zinc-200">
                <div class="text-sm text-zinc-500">Kehadiran Hari Ini</div>
                <div class="text-2xl font-semibold">{{ $presencePct }}%</div>
            </div>
        </div>

        <div class="panel p-6 rounded-lg bg-white shadow-sm border border-zinc-200">
            <h2 class="text-lg font-semibold">Grafik Kehadiran (Mingguan)</h2>

            <div class="flex gap-3 items-end h-40 mt-4">
                @foreach($weekly as $point)
                    <div class="flex-1 text-center">
                        <div
                            class="w-full border border-indigo-200 rounded-lg"
                            style="height: {{ $point['pct'] * 1.6 }}px; background: rgba(79,70,229,0.18);"
                        ></div>
                        <div class="text-xs text-zinc-600 mt-2">{{ $point['date'] }}</div>
                        <div class="text-xs font-semibold text-zinc-900 mt-1">{{ $point['pct'] }}%</div>
                    </div>
                @endforeach
            </div>

            <p class="text-sm text-zinc-600 mt-4">
                Catatan: persentase dihitung dari <b>jumlah status 'hadir'</b> dibanding total record absensi hari tersebut.
            </p>
        </div>

        <div class="panel p-6 rounded-lg bg-white shadow-sm border border-zinc-200">
            <h2 class="text-lg font-semibold">Aktivitas Terbaru</h2>

            <div class="overflow-auto mt-4">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr>
                            <th class="text-left py-2 px-2 border-b border-zinc-200">Waktu</th>
                            <th class="text-left py-2 px-2 border-b border-zinc-200">Mahasiswa</th>
                            <th class="text-left py-2 px-2 border-b border-zinc-200">Course</th>
                            <th class="text-left py-2 px-2 border-b border-zinc-200">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestActivities as $a)
                            <tr>
                                <td class="py-2 px-2 border-b border-zinc-100 text-zinc-600">{{ $a->created_at?->format('d M Y H:i') }}</td>
                                <td class="py-2 px-2 border-b border-zinc-100">{{ $a->student?->name ?? '-' }}</td>
                                <td class="py-2 px-2 border-b border-zinc-100">{{ $a->course?->course_name ?? '-' }}</td>
                                <td class="py-2 px-2 border-b border-zinc-100 font-semibold">{{ $a->status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-3 px-2 text-zinc-600">Belum ada aktivitas absensi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app.sidebar>

