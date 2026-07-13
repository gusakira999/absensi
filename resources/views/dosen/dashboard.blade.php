<x-layouts::app.sidebar :title="__('Dashboard Dosen')">
    <div class="space-y-6">
        <div class="space-y-2">
            <h1 class="text-2xl font-semibold">Dashboard Dosen</h1>
            <p class="text-sm text-zinc-600">Rekap absensi dan monitoring untuk kelas yang Anda ajar.</p>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="p-4 rounded-lg bg-white shadow-sm border border-zinc-200">
                <div class="text-sm text-zinc-500">Total Mata Kuliah Diampu</div>
                <div class="text-2xl font-semibold">
                    {{ \App\Models\Schedule::where('user_id', auth()->id())->distinct('course_id')->count('course_id') }}
                </div>
            </div>

            <div class="p-4 rounded-lg bg-white shadow-sm border border-zinc-200">
                <div class="text-sm text-zinc-500">Rata-rata Kehadiran Mahasiswa</div>
                @php
                    $today = now()->toDateString();
                    $courseIds = \App\Models\Schedule::where('user_id', auth()->id())
                        ->distinct('course_id')
                        ->pluck('course_id');

                    $totalMarked = \App\Models\Attendance::where('attendance_date', $today)
                        ->whereIn('course_id', $courseIds)
                        ->count();

                    $presentPct = 0;
                    if ($totalMarked > 0) {
                        $present = \App\Models\Attendance::where('attendance_date', $today)
                            ->whereIn('course_id', $courseIds)
                            ->whereIn('status', ['hadir','izin','sakit'])
                            ->count();

                        $presentPct = round(($present / $totalMarked) * 100, 1);
                    }
                @endphp
                <div class="text-2xl font-semibold">{{ $presentPct }}%</div>
            </div>

            <div class="p-4 rounded-lg bg-white shadow-sm border border-zinc-200">
                <div class="text-sm text-zinc-500">Total Absensi Hari Ini</div>
                @php
                    $today = now()->toDateString();
                    $courseIds = \App\Models\Schedule::where('user_id', auth()->id())
                        ->distinct('course_id')
                        ->pluck('course_id');
                @endphp
                <div class="text-2xl font-semibold">
                    {{ \App\Models\Attendance::where('attendance_date', $today)->whereIn('course_id', $courseIds)->count() }}
                </div>
            </div>

            <div class="p-4 rounded-lg bg-white shadow-sm border border-zinc-200">
                <div class="text-sm text-zinc-500">Daftar Kelas Hari Ini</div>
                @php
                    $today = now();
                    $dayMap = [1=>'mon',2=>'tue',3=>'wed',4=>'thu',5=>'fri',6=>'sat',0=>'sun'];
                    $dayKey = $dayMap[$today->dayOfWeek] ?? 'mon';

                    $schedulesToday = \App\Models\Schedule::query()
                        ->where('user_id', auth()->id())
                        ->where('day', $dayKey)
                        ->with('course')
                        ->get();
                @endphp

                <div class="text-sm text-zinc-900">
                    @if($schedulesToday->isEmpty())
                        Tidak ada kelas hari ini
                    @else
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($schedulesToday as $s)
                                <li>
                                    {{ $s->course?->course_code }} - {{ $s->course?->course_name }}
                                    ({{ $s->start_time }} - {{ $s->end_time }})
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Access -->
        <div class="p-5 rounded-lg bg-white shadow-sm border border-zinc-200">
            <div class="flex items-center justify-between gap-4 flex-wrap">
                <div class="space-y-1">
                    <div class="font-semibold text-zinc-900">Quick Access</div>
                    <div class="text-sm text-zinc-600">Lihat rekap dan buat absensi dengan cepat.</div>
                </div>

                <div class="flex gap-3 flex-wrap">
                    <a href="{{ route('dosen.recap') }}">
                        <button class="px-4 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                            Lihat Rekap
                        </button>
                    </a>

                    <a href="{{ route('dosen.schedules') }}">
                        <button class="px-4 py-2 rounded-lg bg-zinc-900 text-white font-medium hover:bg-black transition">
                            Buat Absensi
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app.sidebar>

