<div class="space-y-6 p-6" style="background: linear-gradient(135deg, #0f1c15 0%, #1a2f23 50%, #050a07 100%); min-height: 100vh;">
    
    {{-- Header + Filter --}}
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="color: #ffffff; font-size: 24px; font-weight: 700; margin: 0;">Rekap Absensi</h1>
            <p style="color: #8a9b91; font-size: 14px; margin-top: 4px;">Data absensi mahasiswa pada jadwal Anda.</p>
        </div>

        <div style="display: flex; align-items: flex-end; gap: 12px; flex-wrap: wrap;">
            {{-- Filter Tanggal --}}
            <div>
                <label style="display: block; color: #9ca3af; font-size: 12px; font-weight: 500; margin-bottom: 6px;">Tanggal</label>
                <input type="date" wire:model.live="date"
                    style="padding: 8px 12px; border: 1px solid #374151; background: #1f2937; color: #fff; border-radius: 8px; font-size: 14px; outline: none;"
                    class="focus:ring-2 focus:ring-emerald-500 focus:border-transparent" />
            </div>

            {{-- Filter Status --}}
            <div>
                <label style="display: block; color: #9ca3af; font-size: 12px; font-weight: 500; margin-bottom: 6px;">Filter Status</label>
                <select wire:model.live="statusFilter"
                    style="padding: 8px 12px; border: 1px solid #374151; background: #1f2937; color: #fff; border-radius: 8px; font-size: 14px; outline: none;"
                    class="focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
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
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px;">
        <div style="background: rgba(17, 24, 39, 0.6); backdrop-filter: blur(8px); padding: 20px; border-radius: 12px; border: 1px solid #374151; border-left: 4px solid #34d399;">
            <p style="color: #9ca3af; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 8px 0;">Hadir</p>
            <p style="color: #34d399; font-size: 28px; font-weight: 700; margin: 0;">{{ $hadirCount }}</p>
        </div>
        <div style="background: rgba(17, 24, 39, 0.6); backdrop-filter: blur(8px); padding: 20px; border-radius: 12px; border: 1px solid #374151; border-left: 4px solid #fbbf24;">
            <p style="color: #9ca3af; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 8px 0;">Izin</p>
            <p style="color: #fbbf24; font-size: 28px; font-weight: 700; margin: 0;">{{ $izinCount }}</p>
        </div>
        <div style="background: rgba(17, 24, 39, 0.6); backdrop-filter: blur(8px); padding: 20px; border-radius: 12px; border: 1px solid #374151; border-left: 4px solid #60a5fa;">
            <p style="color: #9ca3af; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 8px 0;">Sakit</p>
            <p style="color: #60a5fa; font-size: 28px; font-weight: 700; margin: 0;">{{ $sakitCount }}</p>
        </div>
        <div style="background: rgba(17, 24, 39, 0.6); backdrop-filter: blur(8px); padding: 20px; border-radius: 12px; border: 1px solid #374151; border-left: 4px solid #f87171;">
            <p style="color: #9ca3af; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 8px 0;">Alpha</p>
            <p style="color: #f87171; font-size: 28px; font-weight: 700; margin: 0;">{{ $alphaCount }}</p>
        </div>
    </div>

    {{-- Tabel --}}
    <div style="background: rgba(17, 24, 39, 0.6); backdrop-filter: blur(8px); border-radius: 12px; border: 1px solid #374151; overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #1f2937; border-bottom: 1px solid #374151;">
                <tr>
                    <th style="padding: 14px 16px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px; text-transform: uppercase;">Mata Kuliah</th>
                    <th style="padding: 14px 16px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px; text-transform: uppercase;">Mahasiswa</th>
                    <th style="padding: 14px 16px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px; text-transform: uppercase;">Status</th>
                    <th style="padding: 14px 16px; text-align: left; font-weight: 600; color: #10b981; font-size: 13px; text-transform: uppercase;">Check-in</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $a)
                    @php
                        $badgeColors = [
                            'hadir' => ['bg' => '#065f46', 'text' => '#34d399'],
                            'izin'  => ['bg' => '#92400e', 'text' => '#fbbf24'],
                            'sakit' => ['bg' => '#1e40af', 'text' => '#60a5fa'],
                            'alpha' => ['bg' => '#991b1b', 'text' => '#f87171'],
                        ];
                        $colors = $badgeColors[$a->status] ?? ['bg' => '#374151', 'text' => '#9ca3af'];
                    @endphp
                    <tr style="border-bottom: 1px solid #1f2937; transition: background 0.2s;" 
                        onmouseover="this.style.background='rgba(55, 65, 81, 0.3)'" 
                        onmouseout="this.style.background='transparent'">
                        <td style="padding: 16px;">
                            <div style="color: #ffffff; font-weight: 500; font-size: 14px;">{{ $a->course?->course_name ?? '-' }}</div>
                            <div style="color: #6b7280; font-size: 12px;">{{ $a->course?->course_code }}</div>
                        </td>
                        <td style="padding: 16px;">
                            <div style="color: #ffffff; font-weight: 500; font-size: 14px;">{{ $a->student?->name ?? '-' }}</div>
                            <div style="color: #6b7280; font-size: 12px;">{{ $a->student?->nim ?? '-' }}</div>
                        </td>
                        <td style="padding: 16px;">
                            <span style="padding: 4px 12px; background: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; border-radius: 12px; font-size: 12px; font-weight: 600; display: inline-block;">
                                {{ ucfirst($a->status) }}
                            </span>
                        </td>
                        <td style="padding: 16px; color: #d1d5db; font-size: 14px;">
                            {{ optional($a->check_in_time)->format('H:i') ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding: 40px; text-align: center; color: #6b7280;">
                            <div style="font-size: 40px; margin-bottom: 8px;">📭</div>
                            <div style="color: #9ca3af; font-size: 14px;">Belum ada data absensi untuk tanggal <strong style="color: #d1d5db;">{{ $date }}</strong>.</div>
                            @if($schedules->isEmpty())
                                <div style="font-size: 12px; margin-top: 8px; color: #6b7280;">Anda tidak memiliki jadwal pada hari ini.</div>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div style="margin-top: 20px;">
        {{ $attendances->links(data: ['scrollTo' => false]) }}
    </div>

</div>