<x-layouts::app.sidebar :title="__('Dashboard Dosen')">
    <div class="space-y-6 p-6" style="background: linear-gradient(135deg, #0f1c15 0%, #1a2f23 50%, #050a07 100%); min-height: 100vh;">
        
        <div class="space-y-2">
            <h1 style="color: #ffffff; font-size: 24px; font-weight: 700; margin: 0;">Dashboard Dosen</h1>
            <p style="color: #8a9b91; font-size: 14px; margin: 0;">Rekap absensi dan monitoring untuk kelas yang Anda ajar.</p>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- Card 1: Total Mata Kuliah -->
            <div style="background: rgba(17, 24, 39, 0.6); backdrop-filter: blur(8px); padding: 20px; border-radius: 12px; border: 1px solid #374151;">
                <div style="color: #9ca3af; font-size: 14px; margin-bottom: 8px;">Total Mata Kuliah Diampu</div>
                <div style="color: #ffffff; font-size: 28px; font-weight: 700;">
                    {{ \App\Models\Schedule::where('user_id', auth()->id())->distinct('course_id')->count('course_id') }}
                </div>
            </div>

            <!-- Card 2: Rata-rata Kehadiran -->
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
            <div style="background: rgba(17, 24, 39, 0.6); backdrop-filter: blur(8px); padding: 20px; border-radius: 12px; border: 1px solid #374151;">
                <div style="color: #9ca3af; font-size: 14px; margin-bottom: 8px;">Rata-rata Kehadiran Mahasiswa</div>
                <div style="color: #34d399; font-size: 28px; font-weight: 700;">{{ $presentPct }}%</div>
            </div>

            <!-- Card 3: Total Absensi Hari Ini -->
            @php
                $todayAbsensi = now()->toDateString();
                $courseIdsAbsensi = \App\Models\Schedule::where('user_id', auth()->id())
                    ->distinct('course_id')
                    ->pluck('course_id');
            @endphp
            <div style="background: rgba(17, 24, 39, 0.6); backdrop-filter: blur(8px); padding: 20px; border-radius: 12px; border: 1px solid #374151;">
                <div style="color: #9ca3af; font-size: 14px; margin-bottom: 8px;">Total Absensi Hari Ini</div>
                <div style="color: #ffffff; font-size: 28px; font-weight: 700;">
                    {{ \App\Models\Attendance::where('attendance_date', $todayAbsensi)->whereIn('course_id', $courseIdsAbsensi)->count() }}
                </div>
            </div>

            <!-- Card 4: Daftar Kelas Hari Ini -->
            @php
                $todayDate = now();
                $dayMap = [1=>'mon', 2=>'tue', 3=>'wed', 4=>'thu', 5=>'fri', 6=>'sat', 0=>'sun'];
                $dayKey = $dayMap[$todayDate->dayOfWeek] ?? 'mon';

                $schedulesToday = \App\Models\Schedule::query()
                    ->where('user_id', auth()->id())
                    ->where('day', $dayKey)
                    ->with('course')
                    ->get();
            @endphp
            <div style="background: rgba(17, 24, 39, 0.6); backdrop-filter: blur(8px); padding: 20px; border-radius: 12px; border: 1px solid #374151;">
                <div style="color: #9ca3af; font-size: 14px; margin-bottom: 8px;">Daftar Kelas Hari Ini</div>
                <div style="color: #d1d5db; font-size: 14px;">
                    @if($schedulesToday->isEmpty())
                        <span style="color: #6b7280;">Tidak ada kelas hari ini</span>
                    @else
                        <ul style="list-style-type: disc; padding-left: 20px; margin: 0; display: flex; flex-direction: column; gap: 8px;">
                            @foreach($schedulesToday as $s)
                                <li>
                                    <span style="color: #34d399; font-weight: 600;">{{ $s->course?->course_code }}</span> - {{ $s->course?->course_name }}
                                    <span style="color: #6b7280; font-size: 12px; display: block; margin-top: 2px;">({{ $s->start_time }} - {{ $s->end_time }})</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Access -->
        <div style="background: rgba(17, 24, 39, 0.6); backdrop-filter: blur(8px); padding: 24px; border-radius: 12px; border: 1px solid #374151;">
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
                <div>
                    <div style="color: #ffffff; font-size: 18px; font-weight: 600; margin: 0;">Quick Access</div>
                    <div style="color: #8a9b91; font-size: 14px; margin-top: 4px;">Lihat rekap dan buat absensi dengan cepat.</div>
                </div>

                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="{{ route('dosen.recap') }}" style="text-decoration: none;">
                        <button style="padding: 10px 20px; background: #10b981; color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            Lihat Rekap
                        </button>
                    </a>

                    <a href="{{ route('dosen.schedules') }}" style="text-decoration: none;">
                        <button style="padding: 10px 20px; background: #374151; color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='#4b5563'" onmouseout="this.style.background='#374151'">
                            Buat Absensi
                        </button>
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-layouts::app.sidebar>