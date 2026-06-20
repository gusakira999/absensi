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
                    <flux:menu.item 
                        icon="arrow-right-start-on-rectangle"
                        type="submit"
                        class="w-full"
                    >
                        Logout
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    @endauth
</flux:header>