<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - {{ config('app.name', 'Lentera Aksara') }}</title>

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
                <h1 class="text-3xl font-bold text-[#2F4F4F] dark:text-gray-100 mb-2">Lentera Aksara</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Bergabunglah dengan komunitas pembaca</p>
            </div>

            <!-- Register Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 transition-colors duration-300">
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nama Lengkap
                        </label>
                        <input id="name" 
                               type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required 
                               autofocus 
                               autocomplete="name"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-[#4B5320] dark:focus:ring-[#9acd32] focus:border-transparent transition-all duration-200"
                               placeholder="Masukkan nama lengkap Anda">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Email
                        </label>
                        <input id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autocomplete="username"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-[#4B5320] dark:focus:ring-[#9acd32] focus:border-transparent transition-all duration-200"
                               placeholder="nama@email.com">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Password
                        </label>
                        <input id="password" 
                               type="password" 
                               name="password" 
                               required 
                               autocomplete="new-password"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-[#4B5320] dark:focus:ring-[#9acd32] focus:border-transparent transition-all duration-200"
                               placeholder="Minimal 8 karakter">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Konfirmasi Password
                        </label>
                        <input id="password_confirmation" 
                               type="password" 
                               name="password_confirmation" 
                               required 
                               autocomplete="new-password"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-[#4B5320] dark:focus:ring-[#9acd32] focus:border-transparent transition-all duration-200"
                               placeholder="Ketik ulang password">
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full py-3 px-4 bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 font-semibold rounded-lg hover:bg-[#2F4F4F] dark:hover:bg-[#8ab82e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4B5320] dark:focus:ring-[#9acd32] transition-all duration-200 shadow-md hover:shadow-lg">
                        Daftar Sekarang
                    </button>
                </form>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-semibold text-[#4B5320] dark:text-[#9acd32] hover:underline transition-colors">
                            Masuk di sini
                        </a>
                    </p>
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
