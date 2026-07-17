<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        
        {{-- Custom CSS untuk Tema Hijau Tua Gradasi --}}
        <style>
            /* Sidebar Styling */
            flux-sidebar {
                background: linear-gradient(180deg, #0f1c15 0%, #1a2f23 50%, #050a07 100%) !important;
                border-right: 1px solid #1c2e24 !important;
            }
            
            flux-sidebar-header {
                border-bottom: 1px solid #1c2e24 !important;
            }

            /* Main Content Background */
            body > div.flex-1 {
                background: linear-gradient(135deg, #0f1c15 0%, #1a2f23 50%, #050a07 100%) !important;
            }

            /* Sidebar Menu Item */
            .sidebar-menu-item {
                color: #8a9b91;
                padding: 10px 16px;
                border-radius: 8px;
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                gap: 10px;
                text-decoration: none;
                margin-bottom: 4px;
            }

            .sidebar-menu-item:hover {
                background: rgba(26, 47, 35, 0.8);
                color: #ffffff;
            }

            .sidebar-menu-item.active {
                background: rgba(16, 185, 129, 0.15);
                color: #34d399;
                border-left: 3px solid #34d399;
                padding-left: 13px;
            }

            .sidebar-menu-item svg {
                width: 20px;
                height: 20px;
                color: inherit;
            }

            /* Sidebar Group Heading */
            .sidebar-group-heading {
                color: #8a9b91;
                opacity: 0.6;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                font-weight: 600;
                font-size: 12px;
                margin-bottom: 8px;
                padding: 0 16px;
            }

            /* Sidebar Group */
            .sidebar-group {
                border-bottom: 1px solid #1c2e24;
                padding-bottom: 12px;
                margin-bottom: 12px;
            }

            .sidebar-group:last-child {
                border-bottom: none;
            }

            /* Logo Text */
            .sidebar-logo-text {
                color: #ffffff !important;
            }

            /* Bottom Section */
            .sidebar-bottom-section {
                border-top: 1px solid #1c2e24 !important;
                padding-top: 12px;
                margin-top: 12px;
            }
        </style>
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800 flex">
        
        @auth
        <flux:sidebar sticky collapsible="mobile" class="h-screen min-h-screen border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                @if(auth()->user() && auth()->user()->role === 'admin')
                    <div class="sidebar-group">
                        <div class="sidebar-group-heading">Admin</div>
                        
                        <a href="{{ route('admin.dashboard') }}" 
                           class="sidebar-menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                           wire:navigate>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>{{ __('Dashboard') }}</span>
                        </a>
                        
                        <a href="{{ route('admin.users') }}" 
                           class="sidebar-menu-item {{ request()->routeIs('admin.users') ? 'active' : '' }}"
                           wire:navigate>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span>{{ __('Manajemen User') }}</span>
                        </a>
                        
                        <a href="{{ route('admin.courses') }}" 
                           class="sidebar-menu-item {{ request()->routeIs('admin.courses') ? 'active' : '' }}"
                           wire:navigate>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                            </svg>
                            <span>{{ __('Manajemen Mata Kuliah') }}</span>
                        </a>
                        
                        <a href="{{ route('admin.schedules') }}" 
                           class="sidebar-menu-item {{ request()->routeIs('admin.schedules') ? 'active' : '' }}"
                           wire:navigate>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ __('Kelola Jadwal') }}</span>
                        </a>
                        
                        <a href="{{ route('admin.reports') }}" 
                           class="sidebar-menu-item {{ request()->routeIs('admin.reports') ? 'active' : '' }}"
                           wire:navigate>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <span>{{ __('Monitoring Kehadiran') }}</span>
                        </a>
                    </div>
                @elseif(auth()->user() && auth()->user()->role === 'dosen')
                    <div class="sidebar-group">
                        <div class="sidebar-group-heading">Dosen</div>
                        
                        <a href="{{ route('dosen.dashboard') }}" 
                           class="sidebar-menu-item {{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}"
                           wire:navigate>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>{{ __('Dashboard') }}</span>
                        </a>
                        
                        <a href="{{ route('dosen.courses') }}" 
                           class="sidebar-menu-item {{ request()->routeIs('dosen.courses') ? 'active' : '' }}"
                           wire:navigate>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span>{{ __('Mata Kuliah') }}</span>
                        </a>
                        
                        <a href="{{ route('dosen.schedules') }}" 
                           class="sidebar-menu-item {{ request()->routeIs('dosen.schedules') ? 'active' : '' }}"
                           wire:navigate>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ __('Jadwal Mengajar') }}</span>
                        </a>
                        
                        <a href="{{ route('dosen.recap') }}" 
                           class="sidebar-menu-item {{ request()->routeIs('dosen.recap') ? 'active' : '' }}"
                           wire:navigate>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ __('Rekap Absensi') }}</span>
                        </a>
                        
                        <a href="{{ route('profile.edit') }}" 
                           class="sidebar-menu-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}"
                           wire:navigate>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ __('Settings') }}</span>
                        </a>
                    </div>
                @elseif(auth()->user() && auth()->user()->role === 'mahasiswa')
                    <div class="sidebar-group">
                        <div class="sidebar-group-heading">Mahasiswa</div>
                        
                        <a href="{{ route('mahasiswa.dashboard') }}" 
                           class="sidebar-menu-item {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}"
                           wire:navigate>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>{{ __('Dashboard') }}</span>
                        </a>
                        
                        <a href="{{ route('mahasiswa.jadwal') }}" 
                           class="sidebar-menu-item {{ request()->routeIs('mahasiswa.jadwal') ? 'active' : '' }}"
                           wire:navigate>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ __('Jadwal Kuliah') }}</span>
                        </a>
                        
                        <a href="{{ route('mahasiswa.absensi') }}" 
                           class="sidebar-menu-item {{ request()->routeIs('mahasiswa.absensi') ? 'active' : '' }}"
                           wire:navigate>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ __('Absensi') }}</span>
                        </a>
                    </div>
                @else
                    <div class="sidebar-group">
                        <div class="sidebar-group-heading">Platform</div>
                        
                        <a href="{{ route('dashboard') }}" 
                           class="sidebar-menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                           wire:navigate>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>{{ __('Dashboard') }}</span>
                        </a>
                        
                        <a href="{{ route('category.index') }}" 
                           class="sidebar-menu-item {{ request()->routeIs('category.index') ? 'active' : '' }}"
                           wire:navigate>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span>{{ __('Absensi') }}</span>
                        </a>
                    </div>
                @endif
            </flux:sidebar.nav>

            <flux:spacer />

            <div class="sidebar-bottom-section">
                <a href="https://github.com/laravel/livewire-starter-kit" target="_blank" class="sidebar-menu-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                    <span>{{ __('Repository') }}</span>
                </a>
                
                <a href="https://laravel.com/docs/starter-kits#livewire" target="_blank" class="sidebar-menu-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span>{{ __('Documentation') }}</span>
                </a>
            </div>

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>
        @endauth

        <div class="flex-1 w-full bg-slate-50 min-h-screen">
             {{ $slot }}
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>