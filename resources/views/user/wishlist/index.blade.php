@extends('layouts.app')

@section('title', 'Wishlist Saya - Lentera Aksara')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#2F4F4F] dark:text-gray-100">@t('Wishlist Saya')</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">@t('Daftar buku yang Anda simpan untuk dibeli nanti')</p>
        </div>
        <div class="flex items-center gap-2 text-[#4B5320] dark:text-[#9acd32]">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
            </svg>
            <span class="text-2xl font-semibold">{{ $wishlists->total() }}</span>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <!-- Wishlist Grid -->
    @if($wishlists->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($wishlists as $index => $wishlist)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-all overflow-hidden" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
            <div class="aspect-[3/4] bg-[#F5F5F5] dark:bg-gray-700 overflow-hidden relative group">
                <img src="{{ $wishlist->book->cover_url }}"
                    alt="{{ $wishlist->book->title }}"
                    class="w-full h-full object-cover">
                
                <!-- Remove Button -->
                <form action="{{ route('wishlist.destroy', $wishlist->id) }}" method="POST" class="absolute top-3 right-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-10 h-10 rounded-full bg-red-500 text-white shadow-md flex items-center justify-center hover:bg-red-600 transition-all group/delete opacity-0 group-hover:opacity-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </div>
            <div class="p-4">
                <div class="flex gap-2 flex-wrap mb-2">
                    @foreach($wishlist->book->categories as $category)
                    <span class="text-xs px-2 py-1 bg-[#F5F5F5] dark:bg-gray-700 text-[#4B5320] dark:text-[#9acd32] rounded-full">
                        {{ $category->name }}
                    </span>
                    @endforeach
                </div>
                <h3 class="text-base font-medium text-[#2F4F4F] dark:text-gray-100 mb-1 line-clamp-2">{{ $wishlist->book->title }}</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $wishlist->book->author }}</p>
                
                <!-- Rating Display -->
                @php
                    $avgRating = round($wishlist->book->averageRating(), 1);
                    $reviewCount = $wishlist->book->reviewsCount();
                @endphp
                @if($reviewCount > 0)
                <div class="flex items-center gap-2 mb-3">
                    <div class="flex items-center">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($avgRating))
                                <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @else
                                <svg class="w-3 h-3 text-gray-300 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <span class="text-xs text-gray-600">{{ $avgRating }}</span>
                </div>
                @endif
                
                <div class="flex items-center justify-between mb-3">
                    <div class="text-[#2F4F4F] font-semibold">Rp {{ number_format($wishlist->book->price, 0, ',', '.') }}</div>
                    @if($wishlist->book->stock > 0)
                    <span class="text-xs text-green-600 font-medium">@t('Stok'): {{ $wishlist->book->stock }}</span>
                    @else
                    <span class="text-xs text-red-600 font-medium">@t('Stok Habis')</span>
                    @endif
                </div>
                
                <div class="flex gap-2">
                    <a href="{{ route('books.show', $wishlist->book->id) }}" class="flex-1 text-center px-3 py-2 bg-[#F5F5F5] text-[#4B5320] rounded-lg hover:bg-[#4B5320] hover:text-white transition-colors text-sm font-medium">
                        @t('Detail')
                    </a>
                    @if($wishlist->book->stock > 0)
                    <form action="{{ route('cart.store', $wishlist->book->id) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full px-3 py-2 bg-[#4B5320] text-white rounded-lg hover:bg-[#2F4F4F] transition-colors text-sm font-medium">
                            + @t('Keranjang')
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $wishlists->links() }}
    </div>

    @else
    <!-- Empty State -->
    <div class="text-center py-16">
        <div class="w-24 h-24 bg-[#F5F5F5] rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-[#4B5320]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
        </div>
        <h3 class="text-xl font-medium text-[#2F4F4F] mb-2">@t('Wishlist Kosong')</h3>
        <p class="text-gray-600 mb-6">@t('Anda belum menambahkan buku apapun ke wishlist.')</p>
        <a href="{{ route('books.index') }}" class="inline-flex items-center px-6 py-3 bg-[#4B5320] text-white rounded-lg hover:bg-[#2F4F4F] transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            @t('Jelajahi Buku')
        </a>
    </div>
    @endif
</div>
@endsection
