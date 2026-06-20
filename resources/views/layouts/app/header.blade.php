<flux:header class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    {{-- Sidebar Toggle (Mobile) --}}
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
    
    {{-- Page Title --}}
    <flux:heading size="lg" level="1">
        @yield('title', 'Dashboard')
    </flux:heading>
    
    <flux:spacer />
    
    {{-- User Profile Dropdown --}}
    @auth
        <flux:dropdown position="bottom" align="end">
            <flux:profile 
                name="{{ Auth::user()->name }}"
                initials="{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}"
                class="cursor-pointer"
            />
            
            <flux:menu>
                <flux:menu.heading>
                    {{ Auth::user()->email }}
                </flux:menu.heading>
                
                <flux:menu.separator />
                
                <flux:menu.item 
                    href="{{ route('profile.edit') }}" 
                    icon="user"
                >
                    Profile
                </flux:menu.item>
                
                <flux:menu.separator />
                
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button
                        type="submit"
                        class="flex w-full items-center gap-2 rounded-md px-2 py-1.5 text-left text-sm font-medium text-red-600 transition hover:bg-red-50 hover:text-red-700 dark:text-red-400 dark:hover:bg-red-950/40 dark:hover:text-red-300"
                    >
                        <flux:icon.arrow-right-start-on-rectangle class="size-4" />
                        <span>Logout</span>
                    </button>
                </form>
            </flux:menu>
        </flux:dropdown>
    @endauth
</flux:header>