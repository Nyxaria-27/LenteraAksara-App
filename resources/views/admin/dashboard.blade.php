@extends('layouts.app')

@section('title', 'Admin Dashboard - Lentera Aksara')

@section('content')
<!-- Breadcrumbs -->
<nav class="text-gray-600 dark:text-gray-400 text-sm mb-6 transition-colors duration-300" aria-label="Breadcrumb">
    <ol class="list-none p-0 flex items-center space-x-2">
        <li><a href="{{ route('welcome') }}" class="hover:text-[#4B5320] dark:hover:text-[#9acd32]">@t('Beranda')</a></li>
        <li class="flex items-center space-x-2">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-[#2F4F4F] dark:text-gray-100">@t('Admin Dashboard')</span>
        </li>
    </ol>
</nav>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Books -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="text-[#2F4F4F] dark:text-gray-300">@t('Total Buku')</div>
            <div class="w-10 h-10 rounded-full bg-[#4B5320] dark:bg-[#9acd32] bg-opacity-10 dark:bg-opacity-20 flex items-center justify-center">
                <svg class="w-6 h-6 text-[#4B5320] dark:text-[#9acd32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
        </div>
        <div class="text-3xl font-semibold text-[#2F4F4F] dark:text-gray-100">{{ number_format($booksCount) }}</div>
        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">@t('Judul Terdaftar')</div>
    </div>

    <!-- Total Categories -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="text-[#2F4F4F] dark:text-gray-300">@t('Total Kategori')</div>
            <div class="w-10 h-10 rounded-full bg-[#D2B48C] dark:bg-[#8b7355] bg-opacity-20 dark:bg-opacity-30 flex items-center justify-center">
                <svg class="w-6 h-6 text-[#D2B48C] dark:text-[#D2B48C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
            </div>
        </div>
        <div class="text-3xl font-semibold text-[#2F4F4F] dark:text-gray-100">{{ number_format($categoriesCount) }}</div>
        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">@t('Kategori Aktif')</div>
    </div>

    <!-- Total Users -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="text-[#2F4F4F] dark:text-gray-300">@t('Total Pengguna')</div>
            <div class="w-10 h-10 rounded-full bg-[#4B5320] dark:bg-[#9acd32] bg-opacity-10 dark:bg-opacity-20 flex items-center justify-center">
                <svg class="w-6 h-6 text-[#4B5320] dark:text-[#9acd32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
        <div class="text-3xl font-semibold text-[#2F4F4F] dark:text-gray-100">{{ number_format($usersCount) }}</div>
        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">@t('Pengguna Terdaftar')</div>
    </div>

    <!-- Total Orders -->
    <a href="{{ route('admin.orders.index') }}" class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 block">
        <div class="flex items-center justify-between mb-4">
            <div class="text-[#2F4F4F] dark:text-gray-300">@t('Total Transaksi')</div>
            <div class="w-10 h-10 rounded-full bg-[#D2B48C] dark:bg-[#8b7355] bg-opacity-20 dark:bg-opacity-30 flex items-center justify-center">
                <svg class="w-6 h-6 text-[#D2B48C] dark:text-[#D2B48C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
        </div>
        <div class="text-3xl font-semibold text-[#2F4F4F] dark:text-gray-100">{{ number_format($ordersCount) }}</div>
        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">@t('Transaksi Selesai')</div>
    </a>
</div>

<!-- Latest Books & Categories -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Latest Books -->
    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 transition-colors duration-300">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-serif text-[#2F4F4F] dark:text-gray-100">@t('Buku Terbaru')</h2>
                <a href="{{ route('admin.books.index') }}" class="text-sm text-[#4B5320] dark:text-[#9acd32] hover:underline">@t('Lihat Semua')</a>
            </div>
            
            <div class="space-y-4">
                @foreach($latestBooks as $book)
                <div class="flex items-center gap-4 p-3 hover:bg-[#F5F5F5] dark:hover:bg-gray-700 rounded-lg transition-colors">
                    <div class="w-12 h-16 bg-[#F5F5F5] dark:bg-gray-700 rounded-lg overflow-hidden">
                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-[#2F4F4F] dark:text-gray-100 font-medium truncate">{{ $book->title }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $book->author }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            @foreach($book->categories as $category)
                                <span class="text-xs px-2 py-1 bg-[#F5F5F5] dark:bg-gray-700 text-[#4B5320] dark:text-[#9acd32] rounded-full">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-[#2F4F4F] font-medium">Rp {{ number_format($book->price, 0, ',', '.') }}</div>
                        <div class="text-xs text-gray-600">{{ $book->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Categories Overview -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 transition-colors duration-300">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-serif text-[#2F4F4F] dark:text-gray-100">@t('Kategori')</h2>
            <a href="{{ route('admin.categories.index') }}" class="text-sm text-[#4B5320] dark:text-[#9acd32] hover:underline">@t('Kelola')</a>
        </div>

        <div class="space-y-3">
            @foreach($categories as $category)
            <div class="flex items-center justify-between p-3 hover:bg-[#F5F5F5] dark:hover:bg-gray-700 rounded-lg transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-[#4B5320] dark:bg-[#9acd32] bg-opacity-10 dark:bg-opacity-20 flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#4B5320] dark:text-[#9acd32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <span class="text-[#2F4F4F] dark:text-gray-100">{{ $category->name }}</span>
                </div>
                <span class="text-sm px-2 py-1 bg-[#F5F5F5] dark:bg-gray-700 text-[#4B5320] dark:text-[#9acd32] rounded-full">
                    {{ $category->books_count }} @t('buku')
                </span>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
