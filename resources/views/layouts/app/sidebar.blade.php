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
        <flux:navlist.item 
            href="{{ route('logout') }}" 
            icon="arrow-right-start-on-rectangle"
            variant="danger"
            method="post"
        >
            Logout
        </flux:navlist.item>
    </flux:navlist>
</flux:sidebar>