<div class="space-y-6 p-6" style="background: linear-gradient(135deg, #0f1c15 0%, #1a2f23 50%, #050a07 100%); min-height: 100vh;">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold" style="color: #ffffff;">Manajemen User</h1>
        <p class="text-sm mt-1" style="color: #a7f3d0;">Kelola data dosen dan mahasiswa</p>
    </div>

    <!-- Search -->
    <div>
        <input type="text" wire:model.live.debounce.300ms="searchTerm" placeholder="Cari nama, email, atau NIM..." 
            style="width: 100%; padding: 12px 16px; border: 1px solid #374151; background: rgba(31, 41, 55, 0.8); color: #fff; border-radius: 12px; backdrop-filter: blur(8px);"
            class="focus:outline-none focus:ring-2 focus:ring-emerald-400">
    </div>

    <!-- Tabs -->
    <div class="flex gap-2">
        <button wire:click="$set('selectedRole', 'dosen')" 
            style="padding: 12px 24px; border-radius: 10px; font-weight: 600; border: none; cursor: pointer; transition: all 0.3s;"
            class="{{ $selectedRole === 'dosen' ? '' : '' }}"
            @if($selectedRole === 'dosen')
                style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);"
            @else
                style="background: rgba(55, 65, 81, 0.5); color: #9ca3af;"
            @endif>
            👨‍🏫 Dosen
        </button>
        <button wire:click="$set('selectedRole', 'mahasiswa')" 
            style="padding: 12px 24px; border-radius: 10px; font-weight: 600; border: none; cursor: pointer; transition: all 0.3s;"
            @if($selectedRole === 'mahasiswa')
                style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);"
            @else
                style="background: rgba(55, 65, 81, 0.5); color: #9ca3af;"
            @endif>
            👨‍🎓 Mahasiswa
        </button>
    </div>

    <!-- TAB: DOSEN -->
    @if($selectedRole === 'dosen')
        <div>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold" style="color: #ffffff;">📋 Daftar Dosen ({{ $dosens->total() }})</h2>
                <button wire:click="openCreateForm('dosen')" 
                    style="padding: 10px 20px; background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                    + Tambah Dosen
                </button>
            </div>

            @if($dosens->count() > 0)
                <div style="background: rgba(17, 24, 39, 0.8); border: 1px solid #374151; border-radius: 12px; overflow: hidden; backdrop-filter: blur(8px);">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background: linear-gradient(135deg, #1f2937 0%, #111827 100%); border-bottom: 2px solid #059669;">
                            <tr>
                                <th style="padding: 16px; text-align: left; font-weight: 700; color: #34d399; text-transform: uppercase; font-size: 12px;">No</th>
                                <th style="padding: 16px; text-align: left; font-weight: 700; color: #34d399; text-transform: uppercase; font-size: 12px;">Nama</th>
                                <th style="padding: 16px; text-align: left; font-weight: 700; color: #34d399; text-transform: uppercase; font-size: 12px;">Email</th>
                                <th style="padding: 16px; text-align: left; font-weight: 700; color: #34d399; text-transform: uppercase; font-size: 12px;">Bergabung</th>
                                <th style="padding: 16px; text-align: center; font-weight: 700; color: #34d399; text-transform: uppercase; font-size: 12px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dosens as $dosen)
                                <tr style="border-bottom: 1px solid #374151; transition: background 0.2s;" onmouseover="this.style.background='rgba(55, 65, 81, 0.3)'" onmouseout="this.style.background='transparent'">
                                    <td style="padding: 16px; color: #d1d5db;">{{ $loop->iteration + $dosens->firstItem() - 1 }}</td>
                                    <td style="padding: 16px; color: #ffffff; font-weight: 600;">{{ $dosen->name }}</td>
                                    <td style="padding: 16px; color: #d1d5db;">{{ $dosen->email }}</td>
                                    <td style="padding: 16px; color: #9ca3af; font-size: 13px;">{{ $dosen->created_at->format('d M Y') }}</td>
                                    <td style="padding: 16px; text-align: center;">
                                        <button wire:click="openEditForm({{ $dosen->id }})" 
                                            style="padding: 6px 14px; background: linear-gradient(135deg, #a7f3d0 0%, #6ee7b7 100%); color: #065f46; border: none; border-radius: 6px; font-weight: 600; font-size: 12px; cursor: pointer; margin-right: 6px;">
                                            Edit
                                        </button>
                                        <button wire:click="delete({{ $dosen->id }})" wire:confirm="Yakin hapus dosen ini?"
                                            style="padding: 6px 14px; background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%); color: #991b1b; border: none; border-radius: 6px; font-weight: 600; font-size: 12px; cursor: pointer;">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">{{ $dosens->links(data: ['scrollTo' => false]) }}</div>
            @else
                <div style="background: rgba(17, 24, 39, 0.8); border: 1px solid #374151; border-radius: 12px; padding: 40px; text-align: center; backdrop-filter: blur(8px);">
                    <p style="color: #9ca3af;">Tidak ada data dosen</p>
                </div>
            @endif
        </div>
    @endif

    <!-- TAB: MAHASISWA -->
    @if($selectedRole === 'mahasiswa')
        <div>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold" style="color: #ffffff;">📋 Daftar Mahasiswa ({{ $mahasiswas->total() }})</h2>
                <button wire:click="openCreateForm('mahasiswa')" 
                    style="padding: 10px 20px; background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                    + Tambah Mahasiswa
                </button>
            </div>

            @if($mahasiswas->count() > 0)
                <div style="background: rgba(17, 24, 39, 0.8); border: 1px solid #374151; border-radius: 12px; overflow: hidden; backdrop-filter: blur(8px);">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background: linear-gradient(135deg, #1f2937 0%, #111827 100%); border-bottom: 2px solid #059669;">
                            <tr>
                                <th style="padding: 16px; text-align: left; font-weight: 700; color: #34d399; text-transform: uppercase; font-size: 12px;">No</th>
                                <th style="padding: 16px; text-align: left; font-weight: 700; color: #34d399; text-transform: uppercase; font-size: 12px;">Nama</th>
                                <th style="padding: 16px; text-align: left; font-weight: 700; color: #34d399; text-transform: uppercase; font-size: 12px;">Email</th>
                                <th style="padding: 16px; text-align: left; font-weight: 700; color: #34d399; text-transform: uppercase; font-size: 12px;">NIM</th>
                                <th style="padding: 16px; text-align: left; font-weight: 700; color: #34d399; text-transform: uppercase; font-size: 12px;">Bergabung</th>
                                <th style="padding: 16px; text-align: center; font-weight: 700; color: #34d399; text-transform: uppercase; font-size: 12px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mahasiswas as $mhs)
                                <tr style="border-bottom: 1px solid #374151; transition: background 0.2s;" onmouseover="this.style.background='rgba(55, 65, 81, 0.3)'" onmouseout="this.style.background='transparent'">
                                    <td style="padding: 16px; color: #d1d5db;">{{ $loop->iteration + $mahasiswas->firstItem() - 1 }}</td>
                                    <td style="padding: 16px; color: #ffffff; font-weight: 600;">{{ $mhs->name }}</td>
                                    <td style="padding: 16px; color: #d1d5db;">{{ $mhs->email }}</td>
                                    <td style="padding: 16px; color: #34d399; font-family: monospace;">{{ $mhs->nim ?? '-' }}</td>
                                    <td style="padding: 16px; color: #9ca3af; font-size: 13px;">{{ $mhs->created_at->format('d M Y') }}</td>
                                    <td style="padding: 16px; text-align: center;">
                                        <button wire:click="openEditForm({{ $mhs->id }})" 
                                            style="padding: 6px 14px; background: linear-gradient(135deg, #a7f3d0 0%, #6ee7b7 100%); color: #065f46; border: none; border-radius: 6px; font-weight: 600; font-size: 12px; cursor: pointer; margin-right: 6px;">
                                            Edit
                                        </button>
                                        <button wire:click="delete({{ $mhs->id }})" wire:confirm="Yakin hapus mahasiswa ini?"
                                            style="padding: 6px 14px; background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%); color: #991b1b; border: none; border-radius: 6px; font-weight: 600; font-size: 12px; cursor: pointer;">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">{{ $mahasiswas->links(data: ['scrollTo' => false]) }}</div>
            @else
                <div style="background: rgba(17, 24, 39, 0.8); border: 1px solid #374151; border-radius: 12px; padding: 40px; text-align: center; backdrop-filter: blur(8px);">
                    <p style="color: #9ca3af;">Tidak ada data mahasiswa</p>
                </div>
            @endif
        </div>
    @endif

    <!-- Modal Form -->
    @if($showForm)
        <div style="position: fixed; inset: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: 50;">
            <div style="background: linear-gradient(135deg, #1f2937 0%, #111827 100%); border: 1px solid #374151; border-radius: 16px; width: 100%; max-width: 500px; margin: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.5);">
                <div style="padding: 20px 24px; border-bottom: 1px solid #374151; display: flex; justify-content: space-between; align-items: center;">
                    <h2 style="color: #ffffff; font-size: 20px; font-weight: 700;">{{ $editingId ? '✏️ Edit User' : '➕ Tambah User' }}</h2>
                    <button wire:click="closeForm" style="background: none; border: none; color: #9ca3af; font-size: 24px; cursor: pointer;">&times;</button>
                </div>
                <form wire:submit="save" style="padding: 24px;">
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; color: #d1d5db; margin-bottom: 6px; font-weight: 500;">Nama</label>
                        <input type="text" wire:model="form.name" 
                            style="width: 100%; padding: 10px 14px; border: 1px solid #374151; background: rgba(31, 41, 55, 0.8); color: #fff; border-radius: 8px;" 
                            placeholder="Nama lengkap" required>
                    </div>
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; color: #d1d5db; margin-bottom: 6px; font-weight: 500;">Email</label>
                        <input type="email" wire:model="form.email" 
                            style="width: 100%; padding: 10px 14px; border: 1px solid #374151; background: rgba(31, 41, 55, 0.8); color: #fff; border-radius: 8px;" 
                            placeholder="email@contoh.com" required>
                    </div>
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; color: #d1d5db; margin-bottom: 6px; font-weight: 500;">NIM <span style="color: #6b7280; font-size: 12px;">(Opsional)</span></label>
                        <input type="text" wire:model="form.nim" 
                            style="width: 100%; padding: 10px 14px; border: 1px solid #374151; background: rgba(31, 41, 55, 0.8); color: #fff; border-radius: 8px;" 
                            placeholder="Nomor Induk Mahasiswa">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; color: #d1d5db; margin-bottom: 6px; font-weight: 500;">Password {{ $editingId ? '(Kosongkan jika tidak diubah)' : '' }}</label>
                        <input type="password" wire:model="form.password" 
                            style="width: 100%; padding: 10px 14px; border: 1px solid #374151; background: rgba(31, 41, 55, 0.8); color: #fff; border-radius: 8px;" 
                            placeholder="••••••••">
                    </div>
                    <div style="display: flex; gap: 12px;">
                        <button type="button" wire:click="closeForm" 
                            style="flex: 1; padding: 12px; background: #374151; color: #fff; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                            Batal
                        </button>
                        <button type="submit" 
                            style="flex: 1; padding: 12px; background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>