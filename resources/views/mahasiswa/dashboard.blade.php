<x-layouts::app.sidebar :title="__('Dashboard')">
    <div class="space-y-6">
        <h1 class="text-2xl font-semibold">Dashboard Mahasiswa</h1>

        <div class="grid grid-cols-3 gap-4">
            <div class="p-4 bg-white rounded shadow">Kehadiran: <strong>--%</strong></div>
            <div class="p-4 bg-white rounded shadow">IPK: <strong>--</strong></div>
            <div class="p-4 bg-white rounded shadow">Tugas: <strong>--</strong></div>
        </div>

        <div class="mt-6">
            <h2 class="text-lg font-medium">Navigation</h2>
            <ul class="mt-3 space-y-2">
                <li><a href="{{ route('mahasiswa.jadwal') }}" class="text-indigo-600">Jadwal Kuliah</a></li>
                <li><a href="{{ route('mahasiswa.absensi') }}" class="text-indigo-600">Absensi</a></li>
                <li><a href="{{ route('mahasiswa.deadlines') }}" class="text-indigo-600">Deadline Tugas</a></li>
                <li><a href="{{ route('mahasiswa.tracker') }}" class="text-indigo-600">Tracker IPK</a></li>
                <li><a href="{{ route('mahasiswa.notes') }}" class="text-indigo-600">Catatan Materi</a></li>
            </ul>
        </div>
    </div>
</x-layouts::app.sidebar>
