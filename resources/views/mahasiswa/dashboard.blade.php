<x-layouts::app.sidebar :title="__('Dashboard Mahasiswa')">
    <div class="space-y-6 p-6" style="background: linear-gradient(135deg, #0f1c15 0%, #1a2f23 50%, #050a07 100%); min-height: 100vh;">
        
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 style="color: #02c002ff; font-size: 24px; font-weight: 700; margin: 0;">Dashboard Mahasiswa</h1>
                <p style="color: #8a9b91; font-size: 14px; margin-top: 4px;">Ringkasan kehadiran & aktivitas hari ini</p>
            </div>
        </div>

        {{-- (1) Stat Cards + rincian status --}}
        @php
            $att = auth()->user()?->attendances();
            $today = \Carbon\Carbon::today();

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

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
            <div style="background: rgba(17, 24, 39, 0.6); backdrop-filter: blur(8px); padding: 24px; border-radius: 12px; border: 1px solid #374151;">
                <div style="color: #9ca3af; font-size: 14px; margin-bottom: 8px;">Persentase Hadir</div>
                <div style="color: #34d399; font-size: 32px; font-weight: 700;">{{ $persen }}%</div>
                <div style="color: #6b7280; font-size: 12px; margin-top: 8px;">dari {{ $total }} presensi hari ini</div>
            </div>

            <div style="background: rgba(17, 24, 39, 0.6); backdrop-filter: blur(8px); padding: 24px; border-radius: 12px; border: 1px solid #374151;">
                <div style="color: #9ca3af; font-size: 14px; margin-bottom: 12px;">Status Hari Ini</div>
                <div style="display: flex; flex-direction: column; gap: 8px; font-size: 14px;">
                    <div style="display: flex; justify-content: space-between; color: #d1d5db;"><span>Hadir</span><span style="color: #34d399; font-weight: 600;">{{ $countHadir }}</span></div>
                    <div style="display: flex; justify-content: space-between; color: #d1d5db;"><span>Izin</span><span style="color: #fbbf24; font-weight: 600;">{{ $countIzin }}</span></div>
                    <div style="display: flex; justify-content: space-between; color: #d1d5db;"><span>Sakit</span><span style="color: #60a5fa; font-weight: 600;">{{ $countSakit }}</span></div>
                    <div style="display: flex; justify-content: space-between; color: #d1d5db;"><span>Alpha</span><span style="color: #f87171; font-weight: 600;">{{ $countAlpha }}</span></div>
                </div>
            </div>
        </div>

        {{-- (2) Jadwal Hari Ini + tombol Absen Sekarang --}}
        @php
            $today = \Carbon\Carbon::today();
            $dayMap = [1 => 'mon', 2 => 'tue', 3 => 'wed', 4 => 'thu', 5 => 'fri', 6 => 'sat', 0 => 'sun'];
            $dayKey = $dayMap[$today->dayOfWeek] ?? 'mon';

            $schedulesToday = \App\Models\Schedule::query()
                ->where('day', $dayKey)
                ->with(['course'])
                ->orderBy('start_time')
                ->get();

            $scheduleNow = $schedulesToday->first();
        @endphp

        <div style="background: rgba(17, 24, 39, 0.6); backdrop-filter: blur(8px); padding: 24px; border-radius: 12px; border: 1px solid #374151;">
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
                <div>
                    <h2 style="color: #ffffff; font-size: 18px; font-weight: 600; margin: 0;">📅 Jadwal Hari Ini</h2>
                    <p style="color: #8a9b91; font-size: 14px; margin-top: 4px;">{{ $today->format('d M Y') }}</p>
                </div>

                <div style="display: flex; align-items: center; gap: 12px;">
                    @if($scheduleNow)
                        <a href="{{ route('mahasiswa.absensi') }}"
                            style="padding: 8px 16px; background: #10b981; color: white; border: none; border-radius: 6px; font-weight: 600; font-size: 14px; text-decoration: none; transition: all 0.3s;"
                            onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            Absen Sekarang
                        </a>
                        <span style="padding: 4px 12px; background: rgba(16, 185, 129, 0.2); color: #34d399; border-radius: 12px; font-size: 12px; font-weight: 600;">Sedang jam kuliah</span>
                    @else
                        <button type="button" disabled
                            style="padding: 8px 16px; background: #374151; color: #6b7280; border: none; border-radius: 6px; font-size: 14px; cursor: not-allowed;">
                            Absen Sekarang
                        </button>
                        <span style="padding: 4px 12px; background: rgba(55, 65, 81, 0.3); color: #9ca3af; border-radius: 12px; font-size: 12px; font-weight: 600;">Belum jam</span>
                    @endif
                </div>
            </div>

            <div style="margin-top: 20px; overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid #374151;">
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px;">Mata Kuliah</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px;">Jam</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px;">Ruang</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedulesToday as $s)
                            <tr style="border-bottom: 1px solid #1f2937;">
                                <td style="padding: 14px;">
                                    <div style="color: #ffffff; font-weight: 500; font-size: 14px;">{{ $s->course?->course_name }}</div>
                                    <div style="color: #6b7280; font-size: 12px;">{{ $s->course?->course_code }}</div>
                                </td>
                                <td style="padding: 14px; color: #d1d5db; font-size: 14px;">{{ $s->start_time }} - {{ $s->end_time }}</td>
                                <td style="padding: 14px; color: #d1d5db; font-size: 14px;">{{ $s->room }}</td>
                                <td style="padding: 14px;">
                                    @if($s->id === ($scheduleNow?->id))
                                        <span style="padding: 4px 12px; background: rgba(16, 185, 129, 0.2); color: #34d399; border-radius: 12px; font-size: 12px; font-weight: 600;">Aktif</span>
                                    @else
                                        <span style="padding: 4px 12px; background: rgba(55, 65, 81, 0.3); color: #9ca3af; border-radius: 12px; font-size: 12px; font-weight: 600;">Belum</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="padding: 40px; text-align: center; color: #6b7280;">Tidak ada jadwal hari ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- (3) Riwayat Absensi Terkini --}}
        @php
            $recentAttendances = \App\Models\Attendance::query()
                ->where('user_id', auth()->id())
                ->orderBy('attendance_date', 'desc')
                ->orderBy('check_in_time', 'desc')
                ->limit(5)
                ->get();
        @endphp

        <div style="background: rgba(17, 24, 39, 0.6); backdrop-filter: blur(8px); padding: 24px; border-radius: 12px; border: 1px solid #374151;">
            <h2 style="color: #ffffff; font-size: 18px; font-weight: 600; margin: 0 0 16px 0;">🕒 Riwayat Absensi Terkini</h2>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid #374151;">
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px;">Tanggal</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px;">Mata Kuliah</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentAttendances as $a)
                            @php
                                $statusColors = [
                                    'hadir' => ['bg' => '#065f46', 'text' => '#34d399'],
                                    'izin' => ['bg' => '#92400e', 'text' => '#fbbf24'],
                                    'sakit' => ['bg' => '#1e40af', 'text' => '#60a5fa'],
                                    'alpha' => ['bg' => '#991b1b', 'text' => '#f87171'],
                                ];
                                $colors = $statusColors[strtolower($a->status)] ?? ['bg' => '#374151', 'text' => '#9ca3af'];
                            @endphp
                            <tr style="border-bottom: 1px solid #1f2937;">
                                <td style="padding: 14px; color: #d1d5db; font-size: 14px;">{{ \Carbon\Carbon::parse($a->attendance_date)->format('d M Y') }}</td>
                                <td style="padding: 14px; color: #ffffff; font-weight: 500; font-size: 14px;">{{ $a->course?->course_name ?? ('Course #'.$a->course_id) }}</td>
                                <td style="padding: 14px;">
                                    <span style="padding: 4px 12px; background: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; border-radius: 12px; font-size: 12px; font-weight: 600; display: inline-block;">
                                        {{ ucfirst($a->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="padding: 40px; text-align: center; color: #6b7280;">Belum ada riwayat absensi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-layouts::app.sidebar>