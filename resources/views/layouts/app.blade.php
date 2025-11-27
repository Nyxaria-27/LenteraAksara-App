<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Lentera Aksara - Online Bookstore')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Meta Tags for SEO -->
    <meta name="description" content="@yield('description', 'Lentera Aksara - Your trusted online bookstore for discovering and purchasing quality books. Browse our collection with ease.')">
    <meta name="keywords" content="bookstore, online books, lentera aksara, buy books, book catalog">
    <meta name="author" content="Lentera Aksara">

    <!-- Dark Mode Script (must be in head to prevent flash) -->
    <script>
        // Check localStorage and apply dark mode before page renders
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Fonts (Lora + Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Lora:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Vite (Tailwind CSS + JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js for dropdown interactions -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Small design tokens matching Lentera Aksara */
        :root {
            --color-bg: #F5F5F5;
            --color-text: #2F4F4F;
            --color-accent: #4B5320;
            --color-warm: #D2B48C;
        }

        /* Dark mode color variables */
        .dark {
            --color-bg: #1a1a1a;
            --color-text: #e5e5e5;
            --color-accent: #9acd32;
            --color-warm: #8b7355;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, 'Helvetica Neue', Arial;
            background-color: var(--color-bg);
            color: var(--color-text);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        h1,
        h2,
        h3,
        h4 {
            font-family: 'Lora', serif;
        }

        /* Simple dropdown caret rotate */
        .caret {
            transition: transform .15s ease;
        }

        .caret-open {
            transform: rotate(180deg);
        }

        /* di bagian <style> atau file CSS */
        .dropdown-enter {
            transform: translateY(-4px);
            opacity: 0;
        }

        .dropdown-enter-active {
            transform: translateY(0);
            opacity: 1;
            transition: transform .12s ease, opacity .12s ease;
        }

        #userMenu {
            transform-origin: top right;
            transition: opacity 200ms ease, transform 200ms ease;
        }

        /* ===== Mobile menu animation ===== */
        #mobileMenu {
            transform-origin: top;
            transition: all 200ms ease;
        }

        /* keadaan tersembunyi */
        .menu-hidden {
            opacity: 0;
            transform: translateY(-10px);
            pointer-events: none;
        }

        /* keadaan muncul */
        .menu-visible {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        /* ===== Hamburger icon styles & animation ===== */
        .hamburger {
            display: inline-block;
            width: 1.5rem;
            /* 24px */
            height: 1.5rem;
        }

        .bar {
            position: absolute;
            left: 0;
            right: 0;
            height: 2px;
            border-radius: 2px;
            background-color: currentColor;
            /* inherit color */
            transition: transform 200ms ease, opacity 150ms ease;
        }

        /* posisi tiap bar */
        .bar.top {
            top: 0.25rem;
            /* 4px */
            transform-origin: left center;
        }

        .bar.middle {
            top: 50%;
            transform: translateY(-50%);
        }

        .bar.bottom {
            bottom: 0.25rem;
            /* 4px */
            transform-origin: left center;
        }

        /* ketika terbuka: morph to X */
        .hamburger.open .bar.top {
            transform: translateY(6px) rotate(45deg);
        }

        .hamburger.open .bar.middle {
            opacity: 0;
            transform: scaleX(0.6);
        }

        .hamburger.open .bar.bottom {
            transform: translateY(-6px) rotate(-45deg);
        }

        /* optional: hover effect */
        #navToggleBtn:hover .bar {
            transform-origin: center;
        }
    </style>

    @stack('styles')
</head>

<body class="antialiased text-gray-800 dark:text-gray-100 dark:bg-gray-900 relative transition-colors duration-300">
    <div class="min-h-screen flex flex-col">
        <!-- NAVBAR -->
        <header id="siteHeader" class="sticky top-0 z-50 bg-white/80 dark:bg-gray-800/90 backdrop-blur-sm border-b border-gray-200 dark:border-gray-700 transition-all duration-300">
            <div class="container mx-auto px-6 lg:px-10">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-4">
                        <!-- Logo -->
                        <a href="{{ url('/') }}" class="flex items-center gap-3 no-underline">
                            <!-- Minimal lantern + root icon -->
                            <svg width="38" height="38" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                                <path d="M12 2c1.5 0 3 1 3 2.5S13.5 7 12 7s-3-1.5-3-2.5S10.5 2 12 2z" stroke="var(--color-accent)" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M7 9c0 3.5 2.7 6 5 6s5-2.5 5-6" stroke="var(--color-accent)" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M5 20h14" stroke="var(--color-text)" stroke-opacity=".6" stroke-width="1.2" stroke-linecap="round" />
                            </svg>
                            <div>
                                <div class="text-lg font-semibold text-[#2F4F4F] dark:text-gray-100">Lentera Aksara</div>
                                <div class="text-xs -mt-1 text-gray-600 dark:text-gray-400">Bookstore • Tranquil Growth</div>
                            </div>
                        </a>

                        <!-- Primary Links (desktop) -->
                        <nav class="hidden md:flex items-center ml-6 gap-1">
                            <a href="{{ url('/') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">@t('Beranda')</a>

                            @auth
                            @if (auth()->user()->role === 'user')
                            <a href="{{ route('books.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">@t('Katalog')</a>
                            <a href="{{ route('user.contact.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">@t('Kontak')</a>
                            @else
                            <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">@t('Dasbor')</a>

                            <!-- Admin Management Dropdown -->
                            <div class="relative">
                                <button id="adminManagementBtn" class="flex items-center gap-1 px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" aria-expanded="false">
                                    <span>@t('Manajemen')</span>
                                    <svg class="w-4 h-4 caret transition-transform dark:text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div id="adminManagementMenu" class="hidden opacity-0 scale-95 transform transition-all duration-150 absolute left-0 top-full mt-1 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg ring-1 ring-black dark:ring-gray-700 ring-opacity-5 dark:ring-opacity-50 py-1 z-50">
                                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-4 h-4 text-[#4B5320] dark:text-[#9acd32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        <span>@t('Manajemen Pengguna')</span>
                                    </a>
                                    <a href="{{ route('admin.books.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-4 h-4 text-[#4B5320] dark:text-[#9acd32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        <span>@t('Manajemen Buku')</span>
                                    </a>
                                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-4 h-4 text-[#4B5320] dark:text-[#9acd32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        <span>@t('Manajemen Kategori')</span>
                                    </a>
                                    <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-4 h-4 text-[#4B5320] dark:text-[#9acd32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                        </svg>
                                        <span>@t('Manajemen Pesanan')</span>
                                    </a>
                                    <a href="{{ route('admin.contacts.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-4 h-4 text-[#4B5320] dark:text-[#9acd32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                        </svg>
                                        <span>@t('Pesan Kontak')</span>
                                    </a>
                                    @if(config('features.reviews'))
                                    <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-4 h-4 text-[#4B5320] dark:text-[#9acd32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                        </svg>
                                        <span>@t('Manajemen Review')</span>
                                    </a>
                                    @endif
                                    {{-- Hidden: Edit Tentang (challenge untuk memunculkan kembali) --}}
                                    @if(false)
                                    <a href="{{ route('admin.about.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-4 h-4 text-[#4B5320] dark:text-[#9acd32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>@t('Edit Tentang')</span>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @endif

                            {{-- Link Tentang (hidden untuk admin) --}}
                            @if(auth()->user()->role !== 'admin')
                            <a href="{{ url('/#about') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">@t('Tentang')</a>
                            @endif
                            @endauth
                        </nav>
                    </div>

                    <div class="flex items-center gap-3">
                        @if(config('features.translation'))
                        <!-- Language Switcher (Available for Everyone) -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors flex items-center gap-1" 
                                title="{{ app()->getLocale() == 'id' ? 'Bahasa Indonesia' : 'English' }}">
                                <span class="text-lg">{{ app()->getLocale() == 'id' ? '🇮🇩' : '🇬🇧' }}</span>
                            </button>

                            <!-- Language Dropdown -->
                            <div x-show="open" 
                                @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50"
                                style="display: none;">
                                <div class="py-1">
                                    <a href="{{ route('language.switch', 'id') }}" 
                                        class="flex items-center gap-2 px-4 py-2 text-sm {{ app()->getLocale() == 'id' ? 'bg-gray-100 dark:bg-gray-700 text-[#4B5320] dark:text-[#9acd32] font-semibold' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} transition-colors">
                                        <span class="text-base">🇮🇩</span>
                                        <span>Indonesia</span>
                                    </a>
                                    <a href="{{ route('language.switch', 'en') }}" 
                                        class="flex items-center gap-2 px-4 py-2 text-sm {{ app()->getLocale() == 'en' ? 'bg-gray-100 dark:bg-gray-700 text-[#4B5320] dark:text-[#9acd32] font-semibold' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} transition-colors">
                                        <span class="text-base">🇬🇧</span>
                                        <span>English</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if(config('features.dark_mode'))
                        <!-- Dark Mode Toggle (Available for Everyone) -->
                        <button id="darkModeToggle" class="relative p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group" title="Toggle Dark Mode">
                            <!-- Sun Icon (shown in dark mode) -->
                            <svg id="sunIcon" class="w-5 h-5 text-yellow-500 hidden dark:block transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <!-- Moon Icon (shown in light mode) -->
                            <svg id="moonIcon" class="w-5 h-5 text-[#2F4F4F] dark:text-gray-300 dark:hidden transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                        </button>
                        @endif

                        @auth
                        <!-- User Actions: Cart & Orders (for users only) -->
                        @if(auth()->user()->role === 'user')
                        <div class="hidden md:flex items-center gap-1">
                            @if(config('features.notifications'))
                            <!-- Notification Bell -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open"
                                    class="relative p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group"
                                    title="@t('Notifikasi')">
                                    <svg class="w-5 h-5 text-[#2F4F4F] group-hover:text-[#4B5320] dark:text-gray-100 dark:group-hover:text-[#9acd32]  transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                    @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                                    <span class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] bg-red-500 text-white text-[10px] rounded-full flex items-center justify-center font-semibold px-1">
                                        {{ $unreadNotificationsCount > 9 ? '9+' : $unreadNotificationsCount }}
                                    </span>
                                    @endif
                                </button>

                                <!-- Notification Dropdown -->
                                <div x-show="open"
                                    @click.away="open = false"
                                    x-transition
                                    class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 z-50">
                                    <div class="p-4 border-b border-gray-200 bg-gray-50">
                                        <h3 class="font-semibold text-gray-900">@t('Notifikasi')</h3>
                                    </div>
                                    <div class="max-h-96 overflow-y-auto">
                                        @forelse(auth()->user()->unreadNotifications as $notification)
                                        <a href="{{ $notification->data['url'] ?? '#' }}"
                                            class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 transition-colors">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900">{{ $notification->data['title'] ?? 'Notifikasi' }}</p>
                                                    <p class="text-xs text-gray-600 mt-1 line-clamp-2">
                                                        {{ $notification->data['admin_reply'] ?? $notification->data['message'] ?? 'Ada pesan baru untuk Anda' }}
                                                    </p>
                                                    <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </a>
                                        @empty
                                        <div class="p-8 text-center text-gray-500">
                                            <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                            <p class="text-sm">Tidak ada notifikasi baru</p>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if(config('features.orders'))
                            <!-- My Orders Icon with Badge -->
                            <a href="{{ route('user.orders.index') }}" class="relative p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group" title="@t('Pesanan Saya')">
                                <svg class="w-5 h-5 text-[#2F4F4F] dark:text-gray-300 group-hover:text-[#4B5320] dark:group-hover:text-[#9acd32] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                @if(isset($activeOrdersCount) && $activeOrdersCount > 0)
                                <span class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] bg-[#4B5320] text-white text-[10px] rounded-full flex items-center justify-center font-semibold px-1">
                                    {{ $activeOrdersCount > 9 ? '9+' : $activeOrdersCount }}
                                </span>
                                @endif
                            </a>
                            @endif

                            @if(config('features.cart'))
                            <!-- Cart Link with Badge -->
                            <a href="{{ route('cart.index') }}" class="relative p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group" title="@t('Keranjang Belanja')">
                                <svg class="w-5 h-5 text-[#2F4F4F] dark:text-gray-300 group-hover:text-[#4B5320] dark:group-hover:text-[#9acd32] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                @if(isset($cartCount) && $cartCount > 0)
                                <span class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] bg-[#4B5320] text-white text-[10px] rounded-full flex items-center justify-center font-semibold px-1">
                                    {{ $cartCount > 9 ? '9+' : $cartCount }}
                                </span>
                                @endif
                            </a>
                            @endif

                            @if(config('features.wishlist'))
                            <!-- Wishlist Link with Badge -->
                            <a href="{{ route('wishlist.index') }}" class="relative p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group" title="@t('Wishlist')">
                                <svg class="w-5 h-5 text-[#2F4F4F] dark:text-gray-300 group-hover:text-red-500 dark:group-hover:text-red-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                @if(isset($wishlistCount) && $wishlistCount > 0)
                                <span class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] bg-red-500 text-white text-[10px] rounded-full flex items-center justify-center font-semibold px-1">
                                    {{ $wishlistCount > 9 ? '9+' : $wishlistCount }}
                                </span>
                                @endif
                            </a>
                            @endif

                        </div>
                        @else
                        <!-- Admin Notification Bell -->
                        @if(config('features.notifications'))
                        <div class="hidden md:flex items-center gap-1">
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open"
                                    class="relative p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group"
                                    title="Notifikasi">
                                    <svg class="w-5 h-5 text-[#2F4F4F] dark:text-gray-300 group-hover:text-[#4B5320] dark:group-hover:text-[#9acd32] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                    @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                                    <span class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] bg-red-500 text-white text-[10px] rounded-full flex items-center justify-center font-semibold px-1">
                                        {{ $unreadNotificationsCount > 9 ? '9+' : $unreadNotificationsCount }}
                                    </span>
                                    @endif
                                </button>

                                <!-- Admin Notification Dropdown -->
                                <div x-show="open"
                                    @click.away="open = false"
                                    x-transition
                                    class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 z-50">
                                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                                        <h3 class="font-semibold text-gray-900 dark:text-white">Notifikasi</h3>
                                    </div>
                                    <div class="max-h-96 overflow-y-auto">
                                        @forelse(auth()->user()->unreadNotifications as $notification)
                                        <a href="{{ $notification->data['url'] ?? '#' }}"
                                            class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700 transition-colors">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $notification->data['title'] ?? 'Notifikasi' }}</p>
                                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">
                                                        Dari: {{ $notification->data['user_name'] ?? 'User' }}
                                                        @if(isset($notification->data['subject']))
                                                        <br>Subjek: {{ $notification->data['subject'] }}
                                                        @endif
                                                    </p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </a>
                                        @empty
                                        <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                                            <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                            <p class="text-sm">Tidak ada notifikasi baru</p>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endif

                        <!-- User Menu Dropdown -->
                        <div class="relative hidden md:flex items-center">
                            <button id="userMenuBtn" class="flex items-center gap-2.5 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition-colors" aria-expanded="false">
                                {{-- Avatar --}}
                                <span class="w-8 h-8 rounded-full overflow-hidden shrink-0 flex items-center justify-center text-sm  font-semibold shadow-sm ring-2 ring-white">
                                    @if(Auth::user()->pp)
                                    <img src="{{ asset('storage/' . Auth::user()->pp) }}" alt="Avatar" class="w-full h-full object-cover">
                                    @else
                                    @php
                                    $name = Auth::user()->name ?? 'U';
                                    $initial = strtoupper(mb_substr($name, 0, 1));
                                    $colors = ['bg-blue-200 text-blue-700','bg-green-200 text-green-700','bg-purple-200 text-purple-700','bg-pink-200 text-pink-700','bg-yellow-200 text-yellow-700','bg-indigo-200 text-indigo-700'];
                                    $idx = hexdec(substr(md5($name), 0, 2)) % count($colors);
                                    $bgclass = $colors[$idx];
                                    @endphp
                                    <span class="{{ $bgclass }} w-full h-full flex items-center justify-center">
                                        {{ $initial }}
                                    </span>
                                    @endif
                                </span>

                                <div class="flex flex-col items-start">
                                    <span class="text-sm font-medium text-[#2F4F4F]  dark:text-[#9acd32]">{{ Str::limit(Auth::user()->name, 15) }}</span>
                                    <span class="text-xs text-gray-500">{{ Auth::user()->role === 'admin' ? 'Administrator' : 'Pengguna' }}</span>
                                </div>

                                <svg class="w-4 h-4 text-gray-500 caret transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            {{-- User Dropdown Menu --}}
                            <div id="userMenu" class="hidden opacity-0 scale-95 transform transition-all duration-150 absolute right-0 top-full mt-2 w-64 bg-white dark:bg-gray-800 rounded-lg shadow-xl ring-1 ring-black ring-opacity-5 py-2 z-50">
                                <!-- User Info Header -->
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-[#2F4F4F]  dark:text-[#9acd32]">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ Auth::user()->email }}</p>
                                </div>

                                <!-- Menu Items -->
                                <div class="py-1">
                                    @if(auth()->user()->role === 'user')
                                    <a href="{{ route('books.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-4 h-4 text-[#4B5320]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                        </svg>
                                        <span>@t('Beranda')</span>
                                    </a>
                                    <a href="{{ route('user.contact.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-4 h-4 text-[#4B5320]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                        </svg>
                                        <span>@t('Hubungi Kami')</span>
                                    </a>
                                    @else
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-4 h-4 text-[#4B5320]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        <span>@t('Dasbor')</span>
                                    </a>
                                    @endif

                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-4 h-4 text-[#4B5320]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>@t('Profil Saya')</span>
                                    </a>
                                </div>

                                <!-- Logout -->
                                <div class="border-t border-gray-100 pt-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            <span>@t('Keluar')</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @else
                        <!-- Guest Buttons -->
                        <div class="hidden md:flex items-center gap-3">
                            <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-[#2F4F4F] hover:text-[#4B5320] transition-colors">
                                @t('Masuk')
                            </a>
                            <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg text-sm font-medium bg-[#4B5320] text-white hover:bg-[#2F4F4F] transition-colors shadow-sm">
                                @t('Daftar')
                            </a>
                        </div>
                        @endauth

                        <!-- Mobile Hamburger -->
                        <button id="navToggleBtn" class="md:hidden inline-flex items-center justify-center p-2 rounded-md focus:outline-none" aria-label="Buka menu" aria-expanded="false">
                            <span class="hamburger w-6 h-6 relative block">
                                <span class="bar top"></span>
                                <span class="bar middle"></span>
                                <span class="bar bottom"></span>
                            </span>
                        </button>

                    </div>
                </div>
            </div>

            <!-- Mobile menu (hidden by default) -->
            <div id="mobileMenu" class="hidden md:hidden border-t border-gray-100 dark:border-gray-700">
                <div class="px-4 pt-4 pb-2 space-y-1">
                    <!-- Navigation Links -->
                    <a href="{{ url('/') }}" class="block px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">@t('Beranda')</a>
                    
                    @auth
                    @if(auth()->user()->role === 'user')
                    <a href="{{ route('books.index') }}" class="block px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">@t('Katalog')</a>
                    <a href="{{ route('user.contact.index') }}" class="block px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">@t('Kontak')</a>
                    
                    {{-- Link Tentang (hidden untuk admin) --}}
                    <a href="{{ url('/#about') }}" class="block px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">@t('Tentang')</a>
                    
                    <!-- User Actions -->
                    @if(config('features.cart'))
                    <a href="{{ route('cart.index') }}" class="flex items-center justify-between px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <span>@t('Keranjang Belanja')</span>
                        @if(isset($cartCount) && $cartCount > 0)
                        <span class="px-2 py-1 bg-[#4B5320] text-white text-xs rounded-full">{{ $cartCount }}</span>
                        @endif
                    </a>
                    @endif
                    
                    @if(config('features.wishlist'))
                    <a href="{{ route('wishlist.index') }}" class="flex items-center justify-between px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <span>@t('Wishlist')</span>
                        @if(isset($wishlistCount) && $wishlistCount > 0)
                        <span class="px-2 py-1 bg-red-500 text-white text-xs rounded-full">{{ $wishlistCount }}</span>
                        @endif
                    </a>
                    @endif
                    
                    @if(config('features.orders'))
                    <a href="{{ route('user.orders.index') }}" class="flex items-center justify-between px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <span>@t('Pesanan Saya')</span>
                        @if(isset($activeOrdersCount) && $activeOrdersCount > 0)
                        <span class="px-2 py-1 bg-[#4B5320] text-white text-xs rounded-full">{{ $activeOrdersCount }}</span>
                        @endif
                    </a>
                    @endif
                    
                    @if(config('features.notifications'))
                    <a href="#" class="flex items-center justify-between px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <span>@t('Notifikasi')</span>
                        @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                        <span class="px-2 py-1 bg-red-500 text-white text-xs rounded-full">{{ $unreadNotificationsCount }}</span>
                        @endif
                    </a>
                    @endif
                    
                    @elseif(auth()->user()->role === 'admin')
                    <!-- Admin Links -->
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">@t('Dasbor')</a>
                    
                    <!-- Admin Management Links -->
                    <div class="pl-3 space-y-1 border-l-2 border-gray-200 dark:border-gray-600 ml-3">
                        <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase px-3 py-1">@t('Manajemen')</div>
                        <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded-md text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">@t('Pengguna')</a>
                        <a href="{{ route('admin.books.index') }}" class="block px-3 py-2 rounded-md text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">@t('Buku')</a>
                        <a href="{{ route('admin.categories.index') }}" class="block px-3 py-2 rounded-md text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">@t('Kategori')</a>
                        <a href="{{ route('admin.orders.index') }}" class="block px-3 py-2 rounded-md text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">@t('Pesanan')</a>
                        <a href="{{ route('admin.contacts.index') }}" class="block px-3 py-2 rounded-md text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">@t('Kontak')</a>
                        @if(config('features.reviews'))
                        <a href="{{ route('admin.reviews.index') }}" class="block px-3 py-2 rounded-md text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">@t('Review')</a>
                        @endif
                    </div>
                    
                    @if(config('features.notifications'))
                    <a href="#" class="flex items-center justify-between px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <span>@t('Notifikasi')</span>
                        @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                        <span class="px-2 py-1 bg-red-500 text-white text-xs rounded-full">{{ $unreadNotificationsCount }}</span>
                        @endif
                    </a>
                    @endif
                    @endif
                    @else
                    <!-- Guest Links -->
                    <a href="{{ url('/#about') }}" class="block px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">@t('Tentang')</a>
                    @endauth
                </div>
                <div class="px-4 pb-4 border-t border-gray-100 dark:border-gray-700">
                    <!-- Language & Dark Mode for Mobile (Everyone) - Conditional based on feature flags -->
                    @if(config('features.translation') || config('features.dark_mode'))
                    <div class="py-3 border-b border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between gap-3">
                            @if(config('features.translation'))
                            <!-- Language Switcher Mobile -->
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">@t('Bahasa'):</span>
                                <a href="{{ route('language.switch', 'id') }}" 
                                    class="px-3 py-1.5 rounded-md text-sm {{ app()->getLocale() == 'id' ? 'bg-[#4B5320] text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }} transition-colors">
                                    🇮🇩 ID
                                </a>
                                <a href="{{ route('language.switch', 'en') }}" 
                                    class="px-3 py-1.5 rounded-md text-sm {{ app()->getLocale() == 'en' ? 'bg-[#4B5320] text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }} transition-colors">
                                    🇬🇧 EN
                                </a>
                            </div>
                            @endif
                            
                            @if(config('features.dark_mode'))
                            <!-- Dark Mode Toggle Mobile -->
                            <button id="darkModeToggleMobile" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 transition-colors" title="Toggle Dark Mode">
                                <svg class="w-5 h-5 text-yellow-500 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <svg class="w-5 h-5 text-[#2F4F4F] dark:text-gray-300 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                </svg>
                            </button>
                            @endif
                        </div>
                    </div>
                    @endif

                    @auth
                    <div class="flex justify-start items-center gap-3 pb-2 border-b border-gray-100 pt-3">

                        {{-- Avatar wrapper --}}
                        <span class="w-8 h-8 rounded-full overflow-hidden shrink-0 flex items-center justify-center text-sm font-medium">
                            @if(Auth::user()->pp)
                            <img src="{{ asset('storage/' . Auth::user()->pp) }}" alt="avatar" class="w-full h-full object-cover">
                            @else
                            @php
                            $name = Auth::user()->name ?? 'U';
                            $initial = strtoupper(mb_substr($name, 0, 1));
                            $colors = ['bg-amber-200','bg-indigo-200','bg-emerald-200','bg-pink-200','bg-sky-200','bg-rose-200','bg-lime-200','bg-violet-200'];
                            $idx = hexdec(substr(md5($name), 0, 2)) % count($colors);
                            $bgclass = $colors[$idx];
                            @endphp
                            <span class="{{ $bgclass }} w-full h-full flex items-center justify-center">
                                {{ $initial }}
                            </span>
                            @endif
                        </span>
                        <div class="pt-2">
                            <div class="font-medium">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <div class=" mt-2 space-y-1 top-1 ">
                        <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md">@t('Profil')</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-3 py-2 rounded-md">@t('Keluar')</button>
                        </form>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md">@t('Masuk')</a>
                    <a href="{{ route('register') }}" class="block mt-1 px-3 py-2 rounded-md" style="background-color:var(--color-accent); color:var(--color-bg);">@t('Daftar')</a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Main content area -->
        <main class="flex-1">
            {{-- optional full-bleed content (hero, banners) --}}
            @yield('fullbleed')

            <div class="container mx-auto px-6 lg:px-10 py-8">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-8 transition-colors duration-300">
            <div class="container mx-auto px-6 lg:px-10 py-6 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-600 dark:text-gray-400">© {{ date('Y') }} Lentera Aksara. @t('All rights reserved.')</div>
                <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                    <a href="{{ route('terms') }}" class="hover:underline hover:text-[#4B5320] dark:hover:text-[#9acd32] transition-colors">@t('Syarat')</a>
                    <a href="{{ route('privacy') }}" class="hover:underline hover:text-[#4B5320] dark:hover:text-[#9acd32] transition-colors">@t('Privasi')</a>
                </div>
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navToggle = document.getElementById('navToggleBtn');
            const mobileMenu = document.getElementById('mobileMenu');

            const userBtn = document.getElementById('userMenuBtn');
            const userMenu = document.getElementById('userMenu');
            const caret = userBtn ? userBtn.querySelector('.caret') : null;

            // header shadow on scroll (tetap)
            const siteHeader = document.getElementById('siteHeader');

            function handleHeaderScroll() {
                if (!siteHeader) return;
                if (window.scrollY > 8) {
                    siteHeader.classList.add('shadow-lg');
                } else {
                    siteHeader.classList.remove('shadow-lg');
                }
            }
            window.addEventListener('scroll', handleHeaderScroll, {
                passive: true
            });
            handleHeaderScroll();

            /* -------------------------
               MOBILE MENU + HAMBURGER
               ------------------------- */
            if (navToggle && mobileMenu) {
                // pastikan class awal ada untuk animasi
                if (!mobileMenu.classList.contains('menu-hidden') && mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('menu-hidden');
                }

                // cari elemen hamburger inner
                const hamburger = navToggle.querySelector('.hamburger');

                navToggle.addEventListener('click', function() {
                    const isHidden = mobileMenu.classList.contains('hidden');

                    if (isHidden) {
                        // buka menu
                        mobileMenu.classList.remove('hidden', 'menu-hidden');
                        // trigger reflow then show (safe animation)
                        requestAnimationFrame(() => {
                            mobileMenu.classList.add('menu-visible');
                        });

                        // animasikan hamburger -> open
                        if (hamburger) hamburger.classList.add('open');
                        navToggle.setAttribute('aria-expanded', 'true');
                    } else {
                        // tutup menu (animasi keluar)
                        mobileMenu.classList.remove('menu-visible');
                        mobileMenu.classList.add('menu-hidden');

                        setTimeout(() => {
                            // setelah animasi selesai, sembunyikan dari flow
                            mobileMenu.classList.add('hidden');
                        }, 200); // durasi sama seperti CSS transition

                        // icon kembali
                        if (hamburger) hamburger.classList.remove('open');
                        navToggle.setAttribute('aria-expanded', 'false');
                    }
                });
            }

            /* -------------------------
                   USER MENU & ADMIN MANAGEMENT DROPDOWN
                   dengan fade+scale animasi
                   ------------------------- */
            if (userBtn) {
                userBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (!userMenu) return;

                    if (userMenu.classList.contains('hidden')) {
                        userMenu.classList.remove('hidden');
                        // animasi masuk
                        requestAnimationFrame(() => {
                            userMenu.classList.remove('opacity-0', 'scale-95');
                            userMenu.classList.add('opacity-100', 'scale-100');
                        });
                        userBtn.setAttribute('aria-expanded', 'true');
                    } else {
                        // animasi keluar
                        userMenu.classList.remove('opacity-100', 'scale-100');
                        userMenu.classList.add('opacity-0', 'scale-95');
                        setTimeout(() => {
                            userMenu.classList.add('hidden');
                        }, 150);
                        userBtn.setAttribute('aria-expanded', 'false');
                    }

                    const userCaret = userBtn.querySelector('.caret');
                    userCaret && userCaret.classList.toggle('rotate-180');
                });
            }

            // Admin Management Dropdown
            const adminManagementBtn = document.getElementById('adminManagementBtn');
            const adminManagementMenu = document.getElementById('adminManagementMenu');

            if (adminManagementBtn && adminManagementMenu) {
                adminManagementBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    if (adminManagementMenu.classList.contains('hidden')) {
                        adminManagementMenu.classList.remove('hidden');
                        requestAnimationFrame(() => {
                            adminManagementMenu.classList.remove('opacity-0', 'scale-95');
                            adminManagementMenu.classList.add('opacity-100', 'scale-100');
                        });
                        adminManagementBtn.setAttribute('aria-expanded', 'true');
                    } else {
                        adminManagementMenu.classList.remove('opacity-100', 'scale-100');
                        adminManagementMenu.classList.add('opacity-0', 'scale-95');
                        setTimeout(() => {
                            adminManagementMenu.classList.add('hidden');
                        }, 150);
                        adminManagementBtn.setAttribute('aria-expanded', 'false');
                    }

                    const adminCaret = adminManagementBtn.querySelector('.caret');
                    adminCaret && adminCaret.classList.toggle('rotate-180');
                });
            }

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                // Close user menu
                if (userBtn && userMenu && !userBtn.contains(e.target) && !userMenu.contains(e.target)) {
                    if (!userMenu.classList.contains('hidden')) {
                        userMenu.classList.remove('opacity-100', 'scale-100');
                        userMenu.classList.add('opacity-0', 'scale-95');
                        setTimeout(() => {
                            userMenu.classList.add('hidden');
                        }, 150);
                        userBtn.setAttribute('aria-expanded', 'false');
                        const userCaret = userBtn.querySelector('.caret');
                        userCaret && userCaret.classList.remove('rotate-180');
                    }
                }

                // Close admin management menu
                if (adminManagementBtn && adminManagementMenu && !adminManagementBtn.contains(e.target) && !adminManagementMenu.contains(e.target)) {
                    if (!adminManagementMenu.classList.contains('hidden')) {
                        adminManagementMenu.classList.remove('opacity-100', 'scale-100');
                        adminManagementMenu.classList.add('opacity-0', 'scale-95');
                        setTimeout(() => {
                            adminManagementMenu.classList.add('hidden');
                        }, 150);
                        adminManagementBtn.setAttribute('aria-expanded', 'false');
                        const adminCaret = adminManagementBtn.querySelector('.caret');
                        adminCaret && adminCaret.classList.remove('rotate-180');
                    }
                }
            });

        });

        // Dark Mode Toggle (Desktop & Mobile)
        const darkModeToggle = document.getElementById('darkModeToggle');
        const darkModeToggleMobile = document.getElementById('darkModeToggleMobile');
        
        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            
            if (isDark) {
                html.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                html.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }
        
        if (darkModeToggle) {
            darkModeToggle.addEventListener('click', toggleDarkMode);
        }
        
        if (darkModeToggleMobile) {
            darkModeToggleMobile.addEventListener('click', toggleDarkMode);
        }
    </script>

    @stack('scripts')
</body>

</html>