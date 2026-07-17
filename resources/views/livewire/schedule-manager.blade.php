<div class="space-y-6 p-6" style="background: linear-gradient(135deg, #0f1c15 0%, #1a2f23 50%, #050a07 100%); min-height: 100vh;">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 style="color: #ffffff; font-size: 24px; font-weight: 700; margin: 0;">Manajemen Jadwal</h1>
            <p style="color: #8a9b91; font-size: 14px; margin-top: 4px;">Kelola jadwal kuliah (Admin)</p>
        </div>

        <button wire:click="openCreateForm" 
            style="padding: 8px 16px; background: #10b981; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 14px;">
            + Tambah Jadwal
        </button>
    </div>

    <!-- Search -->
    <div>
        <input type="text" wire:model.live.debounce.300ms="searchTerm" placeholder="Cari course atau dosen..." 
            style="width: 100%; padding: 10px 14px; border: 1px solid #374151; background: #1f2937; color: #fff; border-radius: 8px;">
    </div>

    <!-- Tabel -->
    <div style="background: #111827; border-radius: 8px; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #1f2937; border-bottom: 1px solid #374151;">
                <tr>
                    <th style="padding: 14px 16px; text-align: left; font-weight: 600; color: #10b981; font-size: 14px;">Course</th>
                    <th style="padding: 14px 16px; text-align: left; font-weight: 600; color: #10b981; font-size: 14px;">Dosen</th>
                    <th style="padding: 14px 16px; text-align: left; font-weight: 600; color: #10b981; font-size: 14px;">Hari</th>
                    <th style="padding: 14px 16px; text-align: left; font-weight: 600; color: #10b981; font-size: 14px;">Jam</th>
                    <th style="padding: 14px 16px; text-align: left; font-weight: 600; color: #10b981; font-size: 14px;">Ruang</th>
                    <th style="padding: 14px 16px; text-align: center; font-weight: 600; color: #10b981; font-size: 14px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $s)
                    <tr style="border-bottom: 1px solid #1f2937;">
                        <td style="padding: 16px; color: #e5e7eb; font-size: 14px;">
                            <div style="font-weight: 500; color: #ffffff;">{{ $s->course?->course_name }}</div>
                            <div style="color: #6b7280; font-size: 12px; margin-top: 2px;">{{ $s->course?->course_code }}</div>
                        </td>
                        <td style="padding: 16px; color: #e5e7eb; font-size: 14px;">
                            {{ $s->lecturerUser?->name }}
                        </td>
                        <td style="padding: 16px; color: #e5e7eb; font-size: 14px;">
                            @php
                                $days = ['mon' => 'Senin', 'tue' => 'Selasa', 'wed' => 'Rabu', 'thu' => 'Kamis', 'fri' => 'Jumat', 'sat' => 'Sabtu', 'sun' => 'Minggu'];
                                echo $days[$s->day] ?? $s->day;
                            @endphp
                        </td>
                        <td style="padding: 16px; color: #9ca3af; font-size: 14px;">
                            {{ $s->start_time }} - {{ $s->end_time }}
                        </td>
                        <td style="padding: 16px; color: #9ca3af; font-size: 14px;">
                            {{ $s->room }}
                        </td>
                        <td style="padding: 16px; text-align: center;">
                            <button wire:click="openEditForm({{ $s->id }})" 
                                style="padding: 6px 12px; background: #10b981; color: white; border: none; border-radius: 5px; font-size: 12px; cursor: pointer; margin-right: 6px;">
                                Edit
                            </button>
                            <button wire:click="delete({{ $s->id }})" wire:confirm="Yakin hapus jadwal ini?"
                                style="padding: 6px 12px; background: #ef4444; color: white; border: none; border-radius: 5px; font-size: 12px; cursor: pointer;">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 40px; text-align: center; color: #6b7280;">Belum ada jadwal.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top: 20px;">
        {{ $schedules->links(data: ['scrollTo' => false]) }}
    </div>

    <!-- Modal Form -->
    @if($showForm)
        <div style="position: fixed; inset: 0; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; z-index: 50;">
            <div style="background: #1f2937; border: 1px solid #374151; border-radius: 8px; width: 100%; max-width: 480px; margin: 16px;">
                <div style="padding: 16px 20px; border-bottom: 1px solid #374151; display: flex; justify-content: space-between; align-items: center;">
                    <h2 style="color: #ffffff; font-size: 18px; font-weight: 600; margin: 0;">
                        {{ $editingId ? 'Edit Jadwal' : 'Tambah Jadwal' }}
                    </h2>
                    <button wire:click="closeForm" style="background: none; border: none; color: #9ca3af; font-size: 20px; cursor: pointer;">&times;</button>
                </div>

                <form wire:submit="save" style="padding: 20px;">
                    <div style="margin-bottom: 14px;">
                        <label style="display: block; color: #d1d5db; margin-bottom: 6px; font-size: 13px; font-weight: 500;">Course</label>
                        <select wire:model="course_id" style="width: 100%; padding: 8px 12px; border: 1px solid #374151; background: #111827; color: #fff; border-radius: 6px;">
                            <option value="">-- Pilih Course --</option>
                            @foreach($courses as $c)
                                <option value="{{ $c->id }}">{{ $c->course_code }} - {{ $c->course_name }}</option>
                            @endforeach
                        </select>
                        @error('course_id') <p style="color: #fca5a5; font-size: 11px; margin-top: 4px;">{{ $message }}</p> @enderror
                    </div>

                    <div style="margin-bottom: 14px;">
                        <label style="display: block; color: #d1d5db; margin-bottom: 6px; font-size: 13px; font-weight: 500;">Dosen</label>
                        <select wire:model="user_id" style="width: 100%; padding: 8px 12px; border: 1px solid #374151; background: #111827; color: #fff; border-radius: 6px;">
                            <option value="">-- Pilih Dosen --</option>
                            @foreach($dosens as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id') <p style="color: #fca5a5; font-size: 11px; margin-top: 4px;">{{ $message }}</p> @enderror
                    </div>

                    <div style="margin-bottom: 14px;">
                        <label style="display: block; color: #d1d5db; margin-bottom: 6px; font-size: 13px; font-weight: 500;">Hari</label>
                        <select wire:model="dayInput" style="width: 100%; padding: 8px 12px; border: 1px solid #374151; background: #111827; color: #fff; border-radius: 6px;">
                            <option value="">-- Pilih Hari --</option>
                            <option value="mon">Senin</option>
                            <option value="tue">Selasa</option>
                            <option value="wed">Rabu</option>
                            <option value="thu">Kamis</option>
                            <option value="fri">Jumat</option>
                            <option value="sat">Sabtu</option>
                            <option value="sun">Minggu</option>
                        </select>
                        @error('dayInput') <p style="color: #fca5a5; font-size: 11px; margin-top: 4px;">{{ $message }}</p> @enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                        <div>
                            <label style="display: block; color: #d1d5db; margin-bottom: 6px; font-size: 13px; font-weight: 500;">Mulai</label>
                            <input type="time" wire:model="start_time" style="width: 100%; padding: 8px 12px; border: 1px solid #374151; background: #111827; color: #fff; border-radius: 6px;" />
                            @error('start_time') <p style="color: #fca5a5; font-size: 11px; margin-top: 4px;">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label style="display: block; color: #d1d5db; margin-bottom: 6px; font-size: 13px; font-weight: 500;">Selesai</label>
                            <input type="time" wire:model="end_time" style="width: 100%; padding: 8px 12px; border: 1px solid #374151; background: #111827; color: #fff; border-radius: 6px;" />
                            @error('end_time') <p style="color: #fca5a5; font-size: 11px; margin-top: 4px;">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <label style="display: block; color: #d1d5db; margin-bottom: 6px; font-size: 13px; font-weight: 500;">Ruang</label>
                        <input type="text" wire:model="room" placeholder="Contoh: Lab 1" style="width: 100%; padding: 8px 12px; border: 1px solid #374151; background: #111827; color: #fff; border-radius: 6px;" />
                        @error('room') <p style="color: #fca5a5; font-size: 11px; margin-top: 4px;">{{ $message }}</p> @enderror
                    </div>

                    <div style="display: flex; gap: 10px;">
                        <button type="button" wire:click="closeForm" 
                            style="flex: 1; padding: 10px; background: #374151; color: #fff; border: none; border-radius: 6px; font-weight: 500; cursor: pointer; font-size: 14px;">
                            Batal
                        </button>
                        <button type="submit" 
                            style="flex: 1; padding: 10px; background: #10b981; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 14px;">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>