<x-layouts::app.sidebar :title="__('Manajemen User')">
    <div class="p-6 md:p-10 space-y-6">
        
        <!-- Header Halaman -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Manajemen User</h1>
                <p class="text-slate-500">Kelola data dosen dan mahasiswa dalam sistem.</p>
            </div>
            <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold text-sm transition">
                + Tambah {{ request('role') == 'mahasiswa' ? 'Mahasiswa' : 'Dosen' }}
            </button>
        </div>

        <!-- Filter Tabs -->
        <div class="flex gap-2 p-1 bg-slate-200/50 rounded-xl w-fit">
            <a href="{{ route('admin.users', ['role' => 'dosen']) }}" 
               class="px-4 py-2 rounded-lg font-medium text-sm transition {{ (!request('role') || request('role') == 'dosen') ? 'bg-white shadow text-blue-600' : 'text-slate-600 hover:text-slate-900' }}">
                🧑‍🏫 Dosen
            </a>
            <a href="{{ route('admin.users', ['role' => 'mahasiswa']) }}" 
               class="px-4 py-2 rounded-lg font-medium text-sm transition {{ request('role') == 'mahasiswa' ? 'bg-white shadow text-blue-600' : 'text-slate-600 hover:text-slate-900' }}">
                🎓 Mahasiswa
            </a>
        </div>

        <!-- Tabel Data -->
        <div class="bg-white rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-600 uppercase text-xs font-bold tracking-wider">
                        <tr>
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">Nama</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Bergabung</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @php
                            $roleFilter = request('role', 'dosen');
                            $users = \App\Models\User::where('role', $roleFilter)
                                ->when(request('search'), fn($q) => $q->where('name', 'like', '%'.request('search').'%'))
                                ->orderBy('created_at', 'desc')
                                ->get();
                        @endphp

                        @forelse($users as $index => $user)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-slate-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 flex gap-2">
                                    <button class="px-3 py-1.5 bg-amber-50 text-amber-700 rounded-lg font-semibold text-xs hover:bg-amber-100 transition">Edit</button>
                                    <form method="POST" action="#" onsubmit="return confirm('Yakin hapus?')" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-700 rounded-lg font-semibold text-xs hover:bg-red-100 transition">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-500">
                                    Tidak ada data {{ request('role') == 'mahasiswa' ? 'mahasiswa' : 'dosen' }} yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app.sidebar>