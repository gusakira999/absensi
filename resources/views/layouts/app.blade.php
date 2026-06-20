<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Sistem Absensi') - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxStyles
</head>
<body class="min-h-screen bg-zinc-50 dark:bg-zinc-900 font-sans antialiased">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        @include('layouts.app.sidebar')
        
        {{-- Main Content Area --}}
        <div class="flex-1 flex flex-col">
            {{-- Header --}}
            @include('layouts.app.header')
            
            {{-- Content --}}
            <main class="flex-1 p-6">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    @fluxScripts
</body>
</html>