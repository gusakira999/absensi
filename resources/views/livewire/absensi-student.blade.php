<div class="space-y-6 p-6" style="background: linear-gradient(135deg, #0f1c15 0%, #1a2f23 50%, #050a07 100%); min-height: 100vh;">
    
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 style="color: #2ba527; font-size: 24px; font-weight: 700; margin: 0;">Absensi Mahasiswa</h1>
            <p style="color: #8a9b91; font-size: 14px; margin-top: 4px;">Tanggal: {{ \Carbon\Carbon::today()->format('d M Y') }}</p>
        </div>
    </div>

    <!-- Filter Status -->
    <div style="background: rgba(17, 24, 39, 0.6); backdrop-filter: blur(8px); padding: 16px; border-radius: 12px; border: 1px solid #374151;">
        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <label style="color: #d1d5db; font-size: 14px; font-weight: 500;">Status</label>
            <select wire:model="status" 
                style="padding: 8px 12px; border: 1px solid #374151; background: #1f2937; color: #fff; border-radius: 8px; font-size: 14px; outline: none;"
                class="focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                <option value="hadir">Hadir</option>
                <option value="izin">Izin</option>
                <option value="sakit">Sakit</option>
                <option value="alpha">Alpha</option>
            </select>
        </div>
    </div>

    <!-- Tabel Jadwal -->
    <div style="background: rgba(17, 24, 39, 0.6); backdrop-filter: blur(8px); border-radius: 12px; border: 1px solid #374151; overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #1f2937; border-bottom: 1px solid #374151;">
                <tr>
                    <th style="padding: 14px 16px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px; text-transform: uppercase;">Course</th>
                    <th style="padding: 14px 16px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px; text-transform: uppercase;">Jam</th>
                    <th style="padding: 14px 16px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px; text-transform: uppercase;">Ruang</th>
                    <th style="padding: 14px 16px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px; text-transform: uppercase;">Status Hari Ini</th>
                    <th style="padding: 14px 16px; text-align: center; font-weight: 600; color: #10b981; font-size: 13px; text-transform: uppercase;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $s)
                    @php
                        $courseId = $s->course_id;
                        $att = $attendances->get($courseId);
                        
                        $statusColors = [
                            'hadir' => ['bg' => '#065f46', 'text' => '#34d399'],
                            'izin' => ['bg' => '#92400e', 'text' => '#fbbf24'],
                            'sakit' => ['bg' => '#1e40af', 'text' => '#60a5fa'],
                            'alpha' => ['bg' => '#991b1b', 'text' => '#f87171'],
                        ];
                        $colors = $att ? ($statusColors[strtolower($att->status)] ?? ['bg' => '#374151', 'text' => '#9ca3af']) : ['bg' => '#374151', 'text' => '#9ca3af'];
                    @endphp
                    <tr style="border-bottom: 1px solid #1f2937; transition: background 0.2s;" 
                        onmouseover="this.style.background='rgba(55, 65, 81, 0.3)'" 
                        onmouseout="this.style.background='transparent'">
                        
                        <td style="padding: 16px;">
                            <div style="color: #ffffff; font-weight: 500; font-size: 14px;">{{ $s->course?->course_name }}</div>
                            <div style="color: #6b7280; font-size: 12px;">{{ $s->course?->course_code }}</div>
                        </td>
                        <td style="padding: 16px; color: #d1d5db; font-size: 14px;">{{ $s->start_time }} - {{ $s->end_time }}</td>
                        <td style="padding: 16px; color: #d1d5db; font-size: 14px;">{{ $s->room }}</td>
                        <td style="padding: 16px;">
                            @if($att)
                                <span style="padding: 4px 12px; background: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; border-radius: 12px; font-size: 12px; font-weight: 600; display: inline-block;">
                                    {{ ucfirst($att->status) }}
                                </span>
                                <div style="color: #6b7280; font-size: 11px; margin-top: 6px;">Check-in: {{ optional($att->check_in_time)->format('H:i') }}</div>
                            @else
                                <span style="padding: 4px 12px; background: rgba(55, 65, 81, 0.3); color: #9ca3af; border-radius: 12px; font-size: 12px; font-weight: 600; display: inline-block;">
                                    Belum absen
                                </span>
                            @endif
                        </td>
                        <td style="padding: 16px; text-align: center;">
                            <button type="button" wire:click="checkIn({{ $s->id }})" 
                                style="padding: 8px 16px; background: #10b981; color: white; border: none; border-radius: 6px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s;"
                                onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                {{ $att ? 'Update' : 'Absen' }}
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 40px; text-align: center; color: #6b7280;">Tidak ada jadwal hari ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top: 20px;">
        {{ $schedules->links(data: ['scrollTo' => false]) }}
    </div>

</div>