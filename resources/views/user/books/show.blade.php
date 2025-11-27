@extends('layouts.app')
@section('title', $book->title . ' - Lentera Aksara')

@section('content')
<!-- Breadcrumbs -->
<nav class="text-gray-600 text-sm mb-6" aria-label="Breadcrumb">
    <ol class="list-none p-0 flex items-center space-x-2">
        <li><a href="{{ route('welcome') }}" class="hover:text-[#4B5320] transition-colors">@t('Beranda')</a></li>
        <li class="flex items-center space-x-2">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
            <a href="{{ route('books.index') }}" class="hover:text-[#4B5320] transition-colors">@t('Buku')</a>
        </li>
        <li class="flex items-center space-x-2">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-[#2F4F4F]">{{ Str::limit($book->title, 30) }}</span>
        </li>
    </ol>
</nav>

<!-- Alerts -->
@if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 rounded-lg animate-fade-in">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="text-green-800">{{ session('success') }}</span>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 rounded-lg animate-fade-in">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-red-800">{{ session('error') }}</span>
        </div>
    </div>
@endif

<!-- Book Detail -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
    <!-- Book Cover -->
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 sticky top-4 transition-colors duration-300">
            <div class="aspect-[3/4] bg-[#F5F5F5] dark:bg-gray-700 rounded-lg overflow-hidden mb-4">
                <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://placehold.co/600x800?text=No+Cover' }}" 
                     alt="{{ $book->title }}" 
                     class="w-full h-full object-cover">
            </div>
            
            <!-- Quick Info -->
            <div class="space-y-3 text-sm">
                <div class="flex items-center gap-2 text-gray-600">
                    <svg class="w-5 h-5 text-[#4B5320]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>{{ $book->author }}</span>
                </div>
                <div class="flex items-center gap-2 text-gray-600">
                    <svg class="w-5 h-5 text-[#4B5320]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <span>ISBN: {{ $book->isbn }}</span>
                </div>
                @if($book->stock > 0)
                <div class="flex items-center gap-2 text-green-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>@t('Stok tersedia'): {{ $book->stock }}</span>
                </div>
                @else
                <div class="flex items-center gap-2 text-red-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>@t('Stok habis')</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Book Info -->
    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 md:p-8 transition-colors duration-300">
            <!-- Title & Categories -->
            <div class="mb-6">
                <div class="flex flex-wrap gap-2 mb-3">
                    @foreach($book->categories as $category)
                        <span class="inline-flex items-center px-3 py-1 bg-[#4B5320] bg-opacity-10 text-[#4B5320] dark:bg-green-500 dark:bg-opacity-50 dark:text-gray-300 rounded-full text-sm font-medium">
                            {{ $category->name }}
                        </span>
                    @endforeach
                </div>
                <h1 class="text-3xl md:text-4xl font-serif text-[#2F4F4F] mb-2">{{ $book->title }}</h1>
                <p class="text-lg text-gray-600">oleh <span class="font-medium">{{ $book->author }}</span></p>
            </div>

            <!-- Price & Add to Cart -->
            <div class="bg-[#F5F5F5] rounded-xl p-6 mb-6 dark:bg-gray-700">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                    <div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Harga</div>
                        <div class="text-3xl font-bold text-[#4B5320] dark:text-gray-100">
                            Rp {{ number_format($book->price, 0, ',', '.') }}
                        </div>
                    </div>
                    
                    <div class="flex items-end gap-3">
                        <!-- Wishlist Button -->
                        @if(config('features.wishlist'))
                        @auth
                        @php
                            $isInWishlist = auth()->user()->hasInWishlist($book->id);
                        @endphp
                        <form action="{{ route('wishlist.toggle', $book->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-3 border-2 {{ $isInWishlist ? 'border-red-500 text-red-500 bg-red-50' : 'border-gray-300 text-gray-600 bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300' }} rounded-lg hover:border-red-500 hover:text-red-500 hover:bg-red-50 transition-all font-medium flex items-center gap-2" title="{{ $isInWishlist ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' }}">
                                <svg class="w-5 h-5 {{ $isInWishlist ? 'fill-current' : '' }}" viewBox="0 0 20 20" fill="{{ $isInWishlist ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                </svg>
                                <span class="hidden sm:inline">{{ $isInWishlist ? 'Di Wishlist' : 'Wishlist' }}</span>
                            </button>
                        </form>
                        @endauth
                        @endif
                        
                        @if($book->stock > 0)
                        <form action="{{ route('cart.store', $book->id) }}" method="POST" class="flex items-end gap-3">
                        @csrf
                        <div>
                            <label class="block text-sm text-gray-600 mb-2 dark:text-gray-400">Jumlah</label>
                            <div class="flex items-center border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600">
                                <button type="button" onclick="decrementQuantity()" class="px-4 py-2 hover:bg-gray-50 transition-colors dark:hover:bg-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <input type="number" 
                                       id="quantity" 
                                       name="quantity" 
                                       value="1" 
                                       min="1" 
                                       max="{{ $book->stock }}" 
                                       class="w-16 text-center border-0 focus:ring-0 py-2 dark:bg-gray-700 dark:text-gray-100">
                                <button type="button" onclick="incrementQuantity('{{ $book->stock }}')" class="px-4 py-2 hover:bg-gray-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button type="submit" 
                                class="px-6 py-3 bg-[#4B5320] text-white rounded-lg hover:bg-[#2F4F4F] transition-colors font-medium flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            @t('Tambah ke Keranjang')
                        </button>
                    </form>
                    @else
                    <div class="px-6 py-3 bg-gray-200 text-gray-600 rounded-lg font-medium">
                        @t('Stok Habis')
                    </div>
                    @endif
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($book->description)
            <div class="mb-6">
                <h2 class="text-xl font-serif text-[#2F4F4F] mb-3">@t('Deskripsi')</h2>
                <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                    {{ $book->description }}
                </div>
            </div>
            @endif

            <!-- Additional Actions -->
            <div class="flex flex-wrap gap-3 pt-6 border-t">
                <a href="{{ route('cart.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Lihat Keranjang
                </a>
                <a href="{{ route('books.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Katalog
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Rating & Reviews Section -->
@if(config('features.reviews'))
<div class="mb-12">
    <div class="bg-white rounded-xl shadow-sm p-6 md:p-8 dark:bg-gray-800 transition-colors duration-300">
        <!-- Rating Summary -->
        <div class="flex flex-col md:flex-row md:items-center justify-between pb-6 border-b mb-6">
            <div>
                <h2 class="text-2xl font-serif text-[#2F4F4F] mb-2 dark:text-gray-100">@t('Rating & Ulasan')</h2>
                <p class="text-gray-600 dark:text-gray-400">@t('Bagikan pengalaman Anda dengan buku ini')</p>
            </div>
            <div class="flex items-center gap-4 mt-4 md:mt-0">
                <div class="text-center">
                    <div class="text-4xl font-bold text-[#4B5320] mb-1 dark:text-gray-100">{{ $averageRating }}</div>
                    <div class="flex items-center justify-center mb-1">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($averageRating))
                                <svg class="w-5 h-5 text-yellow-400  fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @elseif($i - 0.5 <= $averageRating)
                                <svg class="w-5 h-5 text-yellow-400" viewBox="0 0 20 20">
                                    <defs>
                                        <linearGradient id="half-{{ $i }}">
                                            <stop offset="50%" stop-color="#FBBF24"/>
                                            <stop offset="50%" stop-color="#E5E7EB"/>
                                        </linearGradient>
                                    </defs>
                                    <path fill="url(#half-{{ $i }})" d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <div class="text-sm text-gray-600">{{ $reviewsCount }} @t('ulasan')</div>
                </div>
            </div>
        </div>

        <!-- Add/Edit Review Form -->
        @auth
            @if($userReview)
                <!-- User Already Reviewed - Show Edit Form (collapsed by default) -->
                <div class="mb-6 p-4 bg-blue-50 dark:bg-gray-900 border border-blue-200 dark:border-blue-700 rounded-lg">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-5 h-5 text-blue-600 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-medium text-blue-900 dark:text-blue-50">@t('Anda sudah memberikan ulasan')</span>
                            </div>
                            <p class="text-sm text-blue-700">@t('Rating Anda'): 
                                <span class="font-semibold">{{ $userReview->rating }}/5</span> ⭐
                            </p>
                        </div>
                        <button onclick="toggleEditReview()" 
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            @t('Edit Ulasan')
                        </button>
                    </div>
                    
                    <!-- Edit Form (Hidden by default) -->
                    <form id="editReviewForm" 
                          action="{{ route('reviews.update', $userReview->id) }}" 
                          method="POST" 
                          class="mt-4 hidden">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2 transition-colors duration-300">@t('Rating')</label>
                            <div class="flex gap-2" id="editStarRating">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" 
                                            onclick="setEditRating({{ $i }})"
                                            class="star-btn hover:scale-110 transition-transform"
                                            data-rating="{{ $i }}">
                                        <svg class="w-8 h-8 {{ $i <= $userReview->rating ? 'text-yellow-400 fill-current' : 'text-gray-300 dark:text-gray-600' }} transition-colors duration-300" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="editRatingInput" value="{{ $userReview->rating }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="editComment" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2 transition-colors duration-300">
                                Komentar (Opsional)
                            </label>
                            <textarea id="editComment" 
                                      name="comment" 
                                      rows="4" 
                                      maxlength="1000"
                                      class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-[#4B5320] focus:border-transparent transition-colors duration-300"
                                      placeholder="Bagikan pengalaman Anda tentang buku ini...">{{ $userReview->comment }}</textarea>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 transition-colors duration-300">Maksimal 1000 karakter</div>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" 
                                    class="px-6 py-2 bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 rounded-lg hover:bg-[#2F4F4F] dark:hover:bg-[#7ab32e] transition-colors font-medium">
                                Perbarui Ulasan
                            </button>
                            <button type="button" 
                                    onclick="toggleEditReview()"
                                    class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                                Batal
                            </button>
                        </div>
                    </form>
                    
                    <!-- Delete Form (Separate from edit form to avoid nesting) -->
                    <form id="deleteReviewForm" 
                          action="{{ route('reviews.destroy', $userReview->id) }}" 
                          method="POST" 
                          onsubmit="return confirm('Yakin ingin menghapus ulasan Anda?')"
                          class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-6 py-2 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors">
                            Hapus Ulasan
                        </button>
                    </form>
                </div>
            @else
                <!-- Add New Review Form -->
                @if($canReview)
                    <div class="mb-6 p-6 bg-[#F5F5F5] dark:bg-gray-800 rounded-lg transition-colors duration-300">
                        <h3 class="text-lg font-semibold text-[#2F4F4F] dark:text-gray-100 mb-4 transition-colors duration-300">Tulis Ulasan Anda</h3>
                        <form action="{{ route('reviews.store', $book->id) }}" method="POST">
                            @csrf
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2 transition-colors duration-300">
                                    Rating <span class="text-red-500">*</span>
                                </label>
                                <div class="flex gap-2" id="starRating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button" 
                                                onclick="setRating({{ $i }})"
                                                class="star-btn hover:scale-110 transition-transform"
                                                data-rating="{{ $i }}">
                                            <svg class="w-8 h-8 text-gray-300 dark:text-gray-600 transition-colors duration-300" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        </button>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="ratingInput" required>
                                @error('rating')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2 transition-colors duration-300">
                                    Komentar (Opsional)
                                </label>
                                <textarea id="comment" 
                                          name="comment" 
                                          rows="4" 
                                          maxlength="1000"
                                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-[#4B5320] focus:border-transparent transition-colors duration-300"
                                          placeholder="Bagikan pengalaman Anda tentang buku ini...">{{ old('comment') }}</textarea>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 transition-colors duration-300">Maksimal 1000 karakter</div>
                                @error('comment')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" 
                                    class="px-6 py-2 bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 rounded-lg hover:bg-[#2F4F4F] dark:hover:bg-[#7ab32e] transition-colors font-medium">
                                Kirim Ulasan
                            </button>
                        </form>
                    </div>
                @else
                    <!-- User hasn't purchased this book yet -->
                    <div class="mb-6 p-6 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-lg transition-colors duration-300">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-amber-900 dark:text-amber-100 mb-1 transition-colors duration-300">Belum Dapat Memberikan Ulasan</h4>
                                <p class="text-sm text-amber-800 dark:text-amber-200 mb-2 transition-colors duration-300">Anda hanya dapat memberikan ulasan untuk buku yang sudah Anda beli dan pesanan telah selesai (status: Completed).</p>
                                <div class="flex gap-3 mt-3">
                                    <!-- @if($book->stock > 0)
                                        <a href="{{ route('books.show', $book->id) }}#purchase" 
                                           class="inline-flex items-center gap-2 px-4 py-2 bg-[#4B5320] text-white text-sm rounded-lg hover:bg-[#2F4F4F] transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                            Beli Buku Ini
                                        </a>
                                    @endif -->
                                    <a href="{{ route('user.orders.index') }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        Lihat Pesanan Saya
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        @else
            <!-- Not Logged In -->
            <div class="mb-6 p-6 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-center transition-colors duration-300">
                <svg class="w-12 h-12 text-gray-400 dark:text-gray-500 mx-auto mb-3 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <p class="text-gray-600 dark:text-gray-400 mb-3 transition-colors duration-300">Silakan login untuk memberikan ulasan</p>
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center gap-2 px-6 py-2 bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 rounded-lg hover:bg-[#2F4F4F] dark:hover:bg-[#7ab32e] transition-colors">
                    Login
                </a>
            </div>
        @endauth

        <!-- Reviews List -->
        @if($reviews->count() > 0)
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-[#2F4F4F] dark:text-gray-100 mb-4">Semua Ulasan ({{ $reviewsCount }})</h3>
                @foreach($reviews as $review)
                    <div class="p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:shadow-sm transition-shadow">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-[#4B5320] dark:bg-[#9acd32] rounded-full flex items-center justify-center text-white dark:text-gray-900 font-semibold">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-medium text-[#2F4F4F] dark:text-gray-100">{{ $review->user->name }}</div>
                                    <div class="flex items-center gap-2">
                                        <div class="flex">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400 fill-current' : 'text-gray-300 dark:text-gray-600' }}" viewBox="0 0 20 20">
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                            @auth
                                @if(auth()->id() === $review->user_id || auth()->user()->isAdmin())
                                    <form action="{{ route('reviews.destroy', $review->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Yakin ingin menghapus ulasan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                        @if($review->comment)
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $review->comment }}</p>
                        @else
                            <p class="text-gray-400 dark:text-gray-500 italic">Tidak ada komentar</p>
                        @endif
                    </div>
                @endforeach

                <!-- Pagination -->
                @if($reviews->hasPages())
                    <div class="mt-6">
                        {{ $reviews->links() }}
                    </div>
                @endif
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
                <p class="text-gray-500 dark:text-gray-400">Belum ada ulasan untuk buku ini</p>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Jadilah yang pertama memberikan ulasan!</p>
            </div>
        @endif
    </div>
</div>
@endif

<!-- Related Books -->
@if($relatedBooks->count() > 0)
<div class="mb-12">
    <h2 class="text-2xl font-serif text-[#2F4F4F] mb-6">Buku Terkait</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($relatedBooks as $relatedBook)
        <a href="{{ route('books.show', $relatedBook->id) }}" 
           class="bg-white dark:bg-gray-800  rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden group">
            <div class="aspect-[3/4] bg-[#F5F5F5] dark:bg-gray-800 overflow-hidden">
                <img src="{{ $relatedBook->cover ? asset('storage/' . $relatedBook->cover) : 'https://placehold.co/300x400?text=No+Cover' }}" 
                     alt="{{ $relatedBook->title }}" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            </div>
            <div class="p-4">
                <h3 class="font-medium text-[#2F4F4F] dark:text-gray-100 mb-1 line-clamp-2">{{ $relatedBook->title }}</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">{{ $relatedBook->author }}</p>
                <div class="text-[#4B5320] font-semibold">
                    Rp {{ number_format($relatedBook->price, 0, ',', '.') }}
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
// Quantity controls
function incrementQuantity(maxStock) {
    const input = document.getElementById('quantity');
    const currentVal = parseInt(input.value) || 1;
    if (currentVal < maxStock) {
        input.value = currentVal + 1;
    }
}

function decrementQuantity() {
    const input = document.getElementById('quantity');
    const currentVal = parseInt(input.value) || 1;
    if (currentVal > 1) {
        input.value = currentVal - 1;
    }
}

// Star Rating System (Add Review)
function setRating(rating) {
    document.getElementById('ratingInput').value = rating;
    
    const stars = document.querySelectorAll('#starRating .star-btn svg');
    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.remove('text-gray-300');
            star.classList.add('text-yellow-400', 'fill-current');
        } else {
            star.classList.remove('text-yellow-400', 'fill-current');
            star.classList.add('text-gray-300');
        }
    });
}

// Star Rating System (Edit Review)
function setEditRating(rating) {
    document.getElementById('editRatingInput').value = rating;
    
    const stars = document.querySelectorAll('#editStarRating .star-btn svg');
    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.remove('text-gray-300');
            star.classList.add('text-yellow-400', 'fill-current');
        } else {
            star.classList.remove('text-yellow-400', 'fill-current');
            star.classList.add('text-gray-300');
        }
    });
}

// Toggle Edit Review Form
function toggleEditReview() {
    const form = document.getElementById('editReviewForm');
    const deleteForm = document.getElementById('deleteReviewForm');
    
    if (form.classList.contains('hidden')) {
        form.classList.remove('hidden');
        // Hide delete button when editing
        if (deleteForm) deleteForm.classList.add('hidden');
    } else {
        form.classList.add('hidden');
        // Show delete button when not editing
        if (deleteForm) deleteForm.classList.remove('hidden');
    }
}

// Hover effect for star rating (Add Review)
document.addEventListener('DOMContentLoaded', function() {
    const starButtons = document.querySelectorAll('#starRating .star-btn');
    starButtons.forEach((btn, index) => {
        btn.addEventListener('mouseenter', function() {
            const rating = index + 1;
            const stars = document.querySelectorAll('#starRating .star-btn svg');
            stars.forEach((star, i) => {
                if (i < rating) {
                    star.classList.add('text-yellow-400', 'fill-current');
                    star.classList.remove('text-gray-300');
                }
            });
        });
    });
    
    const starContainer = document.getElementById('starRating');
    if (starContainer) {
        starContainer.addEventListener('mouseleave', function() {
            const currentRating = parseInt(document.getElementById('ratingInput')?.value) || 0;
            const stars = document.querySelectorAll('#starRating .star-btn svg');
            stars.forEach((star, i) => {
                if (i < currentRating) {
                    star.classList.add('text-yellow-400', 'fill-current');
                    star.classList.remove('text-gray-300');
                } else {
                    star.classList.remove('text-yellow-400', 'fill-current');
                    star.classList.add('text-gray-300');
                }
            });
        });
    }

    // Edit review stars hover
    const editStarButtons = document.querySelectorAll('#editStarRating .star-btn');
    editStarButtons.forEach((btn, index) => {
        btn.addEventListener('mouseenter', function() {
            const rating = index + 1;
            const stars = document.querySelectorAll('#editStarRating .star-btn svg');
            stars.forEach((star, i) => {
                if (i < rating) {
                    star.classList.add('text-yellow-400', 'fill-current');
                    star.classList.remove('text-gray-300');
                }
            });
        });
    });
    
    const editStarContainer = document.getElementById('editStarRating');
    if (editStarContainer) {
        editStarContainer.addEventListener('mouseleave', function() {
            const currentRating = parseInt(document.getElementById('editRatingInput')?.value) || 0;
            const stars = document.querySelectorAll('#editStarRating .star-btn svg');
            stars.forEach((star, i) => {
                if (i < currentRating) {
                    star.classList.add('text-yellow-400', 'fill-current');
                    star.classList.remove('text-gray-300');
                } else {
                    star.classList.remove('text-yellow-400', 'fill-current');
                    star.classList.add('text-gray-300');
                }
            });
        });
    }
});
</script>
@endpush
