<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verifikasi Email - {{ config('app.name', 'Lentera Aksara') }}</title>

    <!-- Dark Mode Script -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Lora:wght@400;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --color-bg: #F5F5F5;
            --color-text: #2F4F4F;
            --color-accent: #4B5320;
            --color-warm: #D2B48C;
        }
        .dark {
            --color-bg: #1a1a1a;
            --color-text: #e5e5e5;
            --color-accent: #9acd32;
            --color-warm: #8b7355;
        }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #F5F5F5 0%, #E8E8E8 100%);
            transition: background-color 0.3s ease;
        }
        .dark body {
            background: linear-gradient(135deg, #1a1a1a 0%, #0f0f0f 100%);
        }
        h1, h2, h3, h4 {
            font-family: 'Lora', serif;
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <!-- Logo & Brand -->
            <div class="text-center mb-8">
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-3 mb-4">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                        <path d="M12 2c1.5 0 3 1 3 2.5S13.5 7 12 7s-3-1.5-3-2.5S10.5 2 12 2z" stroke="var(--color-accent)" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M7 9c0 3.5 2.7 6 5 6s5-2.5 5-6" stroke="var(--color-accent)" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M5 20h14" stroke="var(--color-text)" stroke-opacity=".6" stroke-width="1.2" stroke-linecap="round" />
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-[#2F4F4F] dark:text-gray-100 mb-2">Verifikasi Email</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Konfirmasi alamat email Anda</p>
            </div>

            <!-- Verify Email Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 transition-colors duration-300">
                <!-- Success Message -->
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm text-green-700 dark:text-green-300">
                                Link verifikasi baru telah dikirim ke alamat email yang Anda daftarkan.
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Info Text -->
                <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <p class="text-sm text-blue-700 dark:text-blue-300">
                                Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda dengan mengklik link yang baru saja kami kirimkan ke email Anda.
                            </p>
                            <p class="text-sm text-blue-600 dark:text-blue-400 mt-2">
                                Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkan yang baru.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                    <!-- Resend Verification Email -->
                    <form method="POST" action="{{ route('verification.send') }}" class="flex-1">
                        @csrf
                        <button type="submit" 
                                class="w-full py-3 px-4 bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 font-semibold rounded-lg hover:bg-[#2F4F4F] dark:hover:bg-[#8ab82e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4B5320] dark:focus:ring-[#9acd32] transition-all duration-200 shadow-md hover:shadow-lg">
                            Kirim Ulang Email
                        </button>
                    </form>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="text-sm text-gray-600 dark:text-gray-400 hover:text-[#4B5320] dark:hover:text-[#9acd32] hover:underline transition-colors whitespace-nowrap">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="mt-6 text-center">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 hover:text-[#4B5320] dark:hover:text-[#9acd32] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</body>
</html>
