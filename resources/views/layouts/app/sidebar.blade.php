<flux:sidebar>
    <flux:sidebar.toggle class="lg:hidden" />

    <flux:brand href="{{ route('admin.dashboard') }}" name="Sistem Absensi" logo="📋" class="px-2" />

    <flux:navlist>
        <flux:navlist.item 
            href="{{ route('admin.dashboard') }}" 
            icon="home"
            :current="request()->routeIs('admin.dashboard')"
        >
            Dashboard
        </flux:navlist.item>

        <flux:navlist.item 
            href="{{ route('admin.mahasiswa.index') }}" 
            icon="users"
            :current="request()->routeIs('admin.mahasiswa.*')"
        >
            Data Mahasiswa
        </flux:navlist.item>

        <flux:navlist.item 
            href="{{ route('admin.dosen.index') }}" 
            icon="academic-cap"
            :current="request()->routeIs('admin.dosen.*')"
        >
            Data Dosen
        </flux:navlist.item>
    </flux:navlist>

    <flux:spacer />

    <flux:navlist>
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button
                type="submit"
                class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left text-sm font-medium text-red-600 transition hover:bg-red-50 hover:text-red-700 dark:text-red-400 dark:hover:bg-red-950/40 dark:hover:text-red-300"
            >
                <flux:icon.arrow-right-start-on-rectangle class="size-4" />
                <span>Logout</span>
            </button>
        </form>
    </flux:navlist>
</flux:sidebar>