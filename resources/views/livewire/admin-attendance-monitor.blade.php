<div class="space-y-6 p-6" style="background: linear-gradient(135deg, #0f1c15 0%, #1a2f23 50%, #050a07 100%); min-height: 100vh;">
    <div class="space-y-1">
        <h1 style="color: #ffffff; font-size: 24px; font-weight: 700; margin: 0;">Monitoring Kehadiran</h1>
        <p style="color: #8a9b91; font-size: 14px; margin: 0;">Pantau dan filter seluruh data absensi mahasiswa.</p>
    </div>

    {{-- Stat Cards --}}
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
        @php
            $statsConfig = [
                ['label' => 'Total Record', 'value' => $stats['total'], 'color' => '#ffffff'],
                ['label' => 'Hadir', 'value' => $stats['hadir'], 'color' => '#34d399'],
                ['label' => 'Izin', 'value' => $stats['izin'], 'color' => '#fbbf24'],
                ['label' => 'Sakit', 'value' => $stats['sakit'], 'color' => '#60a5fa'],
                ['label' => 'Alpha', 'value' => $stats['alpha'], 'color' => '#f87171'],
                ['label' => '% Hadir', 'value' => $stats['presencePct'] . '%', 'color' => '#ffffff'],
            ];
        @endphp
        @foreach($statsConfig as $stat)
            <div style="background: #111827; padding: 16px; border-radius: 8px; border: 1px solid #374151;">
                <div style="color: #6b7280; font-size: 13px; margin-bottom: 8px;">{{ $stat['label'] }}</div>
                <div style="color: {{ $stat['color'] }}; font-size: 24px; font-weight: 700;">{{ $stat['value'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- Filters --}}
    <div style="background: #111827; padding: 20px; border-radius: 8px; border: 1px solid #374151;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
            <div>
                <label style="display: block; color: #9ca3af; font-size: 12px; font-weight: 500; margin-bottom: 6px;">Dari Tanggal</label>
                <input type="date" wire:model.live="dateFrom" 
                    style="width: 100%; padding: 8px 12px; border: 1px solid #374151; background: #1f2937; color: #fff; border-radius: 6px; font-size: 13px;">
            </div>
            <div>
                <label style="display: block; color: #9ca3af; font-size: 12px; font-weight: 500; margin-bottom: 6px;">Sampai Tanggal</label>
                <input type="date" wire:model.live="dateTo" 
                    style="width: 100%; padding: 8px 12px; border: 1px solid #374151; background: #1f2937; color: #fff; border-radius: 6px; font-size: 13px;">
            </div>
            <div>
                <label style="display: block; color: #9ca3af; font-size: 12px; font-weight: 500; margin-bottom: 6px;">Mata Kuliah</label>
                <select wire:model.live="courseId" 
                    style="width: 100%; padding: 8px 12px; border: 1px solid #374151; background: #1f2937; color: #fff; border-radius: 6px; font-size: 13px;">
                    <option value="0">Semua Mata Kuliah</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->course_code }} — {{ $course->course_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display: block; color: #9ca3af; font-size: 12px; font-weight: 500; margin-bottom: 6px;">Status</label>
                <select wire:model.live="statusFilter" 
                    style="width: 100%; padding: 8px 12px; border: 1px solid #374151; background: #1f2937; color: #fff; border-radius: 6px; font-size: 13px;">
                    <option value="">Semua Status</option>
                    <option value="hadir">Hadir</option>
                    <option value="izin">Izin</option>
                    <option value="sakit">Sakit</option>
                    <option value="alpha">Alpha</option>
                </select>
            </div>
            <div style="grid-column: span 2;">
                <label style="display: block; color: #9ca3af; font-size: 12px; font-weight: 500; margin-bottom: 6px;">Cari Mahasiswa</label>
                <input type="text" wire:model.live.debounce.300ms="searchTerm" placeholder="Nama, email, atau NIM..." 
                    style="width: 100%; padding: 8px 12px; border: 1px solid #374151; background: #1f2937; color: #fff; border-radius: 6px; font-size: 13px;">
            </div>
        </div>

        <div style="margin-top: 16px; text-align: right;">
            <button type="button" wire:click="resetFilters" 
                style="padding: 8px 16px; background: #374151; color: #fff; border: none; border-radius: 6px; font-size: 13px; font-weight: 500; cursor: pointer;">
                Reset Filter
            </button>
        </div>
    </div>

    {{-- Table --}}
    <div style="background: #111827; border-radius: 8px; border: 1px solid #374151; overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #1f2937; border-bottom: 1px solid #374151;">
                <tr>
                    <th style="padding: 14px 16px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px;">Tanggal</th>
                    <th style="padding: 14px 16px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px;">Mahasiswa</th>
                    <th style="padding: 14px 16px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px;">Mata Kuliah</th>
                    <th style="padding: 14px 16px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px;">Status</th>
                    <th style="padding: 14px 16px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px;">Check-in</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($attendances as $attendance)
                    @php
                        $statusColors = [
                            'hadir' => ['bg' => '#065f46', 'text' => '#34d399'],
                            'izin' => ['bg' => '#92400e', 'text' => '#fbbf24'],
                            'sakit' => ['bg' => '#1e40af', 'text' => '#60a5fa'],
                            'alpha' => ['bg' => '#991b1b', 'text' => '#f87171'],
                        ];
                        $colors = $statusColors[$attendance->status] ?? ['bg' => '#374151', 'text' => '#9ca3af'];
                    @endphp
                    <tr style="border-bottom: 1px solid #1f2937;">
                        <td style="padding: 16px; color: #d1d5db; font-size: 14px; white-space: nowrap;">
                            {{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d M Y') }}
                        </td>
                        <td style="padding: 16px;">
                            <div style="color: #ffffff; font-weight: 500; font-size: 14px;">{{ $attendance->student?->name ?? '-' }}</div>
                            <div style="color: #6b7280; font-size: 12px;">{{ $attendance->student?->nim ?? $attendance->student?->email }}</div>
                        </td>
                        <td style="padding: 16px;">
                            <div style="color: #ffffff; font-weight: 500; font-size: 14px;">{{ $attendance->course?->course_name ?? '-' }}</div>
                            <div style="color: #6b7280; font-size: 12px;">{{ $attendance->course?->course_code }}</div>
                        </td>
                        <td style="padding: 16px;">
                            <span style="padding: 4px 12px; background: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; border-radius: 12px; font-size: 12px; font-weight: 600; display: inline-block;">
                                {{ ucfirst($attendance->status) }}
                            </span>
                        </td>
                        <td style="padding: 16px; color: #9ca3af; font-size: 14px;">
                            @if ($attendance->check_in_time)
                                {{ \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i') }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 40px; text-align: center; color: #6b7280;">
                            Tidak ada data absensi untuk filter yang dipilih.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $attendances->links(data: ['scrollTo' => false]) }}
    </div>
</div>