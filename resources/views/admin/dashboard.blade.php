{{-- Admin Dashboard - Tema Hijau Tua Gradasi --}}
<x-layouts::app.sidebar :title="__('Admin Dashboard')">
    <div class="space-y-6 p-6" style="background: linear-gradient(135deg, #0f1c15 0%, #1a2f23 50%, #050a07 100%); min-height: 100vh;">
        @php
            $totalMahasiswa = \App\Models\User::query()->where('role', 'mahasiswa')->count();
            $totalDosen = \App\Models\User::query()->where('role', 'dosen')->count();
            $totalMataKuliah = \App\Models\Course::query()->count();
            $today = \Carbon\Carbon::today()->toDateString();
            
            $totalAttendanceToday = \App\Models\Attendance::query()
                ->whereDate('attendance_date', $today)->count();
            $hadirToday = \App\Models\Attendance::query()
                ->whereDate('attendance_date', $today)
                ->where('status', 'hadir')->count();
            $presencePct = $totalAttendanceToday > 0
                ? round(($hadirToday / $totalAttendanceToday) * 100) : 0;

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

        <!-- Header -->
        <div class="space-y-1">
            <h1 style="color: #ffffff; font-size: 24px; font-weight: 700; margin: 0;">Admin Dashboard</h1>
            <p style="color: #8a9b91; font-size: 14px; margin: 0;">Ringkasan kondisi kehadiran mahasiswa hari ini.</p>
        </div>

        <!-- Stats Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
            <div style="background: rgba(17, 24, 39, 0.6); backdrop-filter: blur(8px); padding: 24px; border-radius: 12px; border: 1px solid #374151;">
                <div style="color: #9ca3af; font-size: 14px; margin-bottom: 8px;">Total Mahasiswa</div>
                <div style="color: #ffffff; font-size: 32px; font-weight: 700;">{{ number_format($totalMahasiswa) }}</div>
            </div>
            <div style="background: rgba(17, 24, 39, 0.6); backdrop-filter: blur(8px); padding: 24px; border-radius: 12px; border: 1px solid #374151;">
                <div style="color: #9ca3af; font-size: 14px; margin-bottom: 8px;">Total Dosen</div>
                <div style="color: #ffffff; font-size: 32px; font-weight: 700;">{{ number_format($totalDosen) }}</div>
            </div>
            <div style="background: rgba(17, 24, 39, 0.6); backdrop-filter: blur(8px); padding: 24px; border-radius: 12px; border: 1px solid #374151;">
                <div style="color: #9ca3af; font-size: 14px; margin-bottom: 8px;">Total Mata Kuliah</div>
                <div style="color: #34d399; font-size: 32px; font-weight: 700;">{{ number_format($totalMataKuliah) }}</div>
            </div>
            <div style="background: rgba(17, 24, 39, 0.6); backdrop-filter: blur(8px); padding: 24px; border-radius: 12px; border: 1px solid #374151;">
                <div style="color: #9ca3af; font-size: 14px; margin-bottom: 8px;">Kehadiran Hari Ini</div>
                <div style="color: #34d399; font-size: 32px; font-weight: 700;">{{ $presencePct }}%</div>
            </div>
        </div>

        <!-- Grafik -->
        <div style="background: rgba(17, 24, 39, 0.6); backdrop-filter: blur(8px); padding: 24px; border-radius: 12px; border: 1px solid #374151;">
            <h2 style="color: #ffffff; font-size: 18px; font-weight: 600; margin: 0 0 20px 0;">Grafik Kehadiran (Mingguan)</h2>
            <div style="display: flex; gap: 12px; align-items: flex-end; height: 160px;">
                @foreach($weekly as $point)
                    <div style="flex: 1; text-align: center;">
                        <div style="width: 100%; border: 1px solid #059669; border-radius: 6px; background: rgba(16, 185, 129, 0.2); height: {{ max($point['pct'] * 1.6, 4) }}px; transition: all 0.3s;" onmouseover="this.style.background='rgba(16, 185, 129, 0.4)'" onmouseout="this.style.background='rgba(16, 185, 129, 0.2)'"></div>
                        <div style="color: #6b7280; font-size: 11px; margin-top: 8px;">{{ $point['date'] }}</div>
                        <div style="color: #d1d5db; font-size: 12px; font-weight: 600; margin-top: 4px;">{{ $point['pct'] }}%</div>
                    </div>
                @endforeach
            </div>
            <p style="color: #6b7280; font-size: 13px; margin-top: 16px;">
                Catatan: persentase dihitung dari <b style="color: #9ca3af;">jumlah status 'hadir'</b> dibanding total record absensi hari tersebut.
            </p>
        </div>

        <!-- Tabel Aktivitas -->
        <div style="background: rgba(17, 24, 39, 0.6); backdrop-filter: blur(8px); padding: 24px; border-radius: 12px; border: 1px solid #374151;">
            <h2 style="color: #ffffff; font-size: 18px; font-weight: 600; margin: 0 0 20px 0;">Aktivitas Terbaru</h2>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid #374151;">
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px;">Waktu</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px;">Mahasiswa</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px;">Mata Kuliah</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestActivities as $a)
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
                                <td style="padding: 14px 12px; color: #9ca3af; font-size: 13px;">
                                    {{ $a->created_at?->format('d M Y H:i') }}
                                </td>
                                <td style="padding: 14px 12px; color: #ffffff; font-weight: 500; font-size: 14px;">
                                    {{ $a->student?->name ?? '-' }}
                                </td>
                                <td style="padding: 14px 12px; color: #d1d5db; font-size: 14px;">
                                    {{ $a->course?->course_name ?? '-' }}
                                </td>
                                <td style="padding: 14px 12px;">
                                    <span style="padding: 4px 12px; background: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; border-radius: 12px; font-size: 12px; font-weight: 600; display: inline-block;">
                                        {{ ucfirst($a->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="padding: 40px; text-align: center; color: #6b7280;">Belum ada aktivitas absensi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app.sidebar>