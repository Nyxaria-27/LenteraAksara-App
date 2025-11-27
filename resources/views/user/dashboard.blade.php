@extends('layouts.app')

@section('title', 'Dashboard - Lentera Aksara')

@section('content')
<style>
    #searchButton {
        transition: transform 0.15s ease, background-color 0.2s ease;
    }

    #searchButton:hover {
        transform: translateY(-1px);
    }

    #searchButton:active {
        transform: scale(0.97);
    }
</style>
<!-- Header Section -->
<div class="mb-8">
    <h1 class="text-3xl font-serif text-[#2F4F4F] dark:text-gray-100 mb-2">@t('Selamat Datang'), {{ Auth::user()->name }}</h1>
    <p class="text-gray-600 dark:text-gray-400">@t('Temukan ribuan buku pilihan untuk koleksi perpustakaanmu.')</p>
</div>

<!-- Search and Filter Section -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-8 transition-colors duration-300">
    <div class="flex flex-col md:flex-row md:items-center gap-4">
        <!-- Search with Auto-suggestion -->
        <div class="flex-1 relative ">

            <div class="flex w-full">
                <input
                    type="text"
                    id="searchBooks"
                    placeholder="@t('Cari judul buku, penulis, atau ISBN...')"
                    class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-l-lg focus:ring-[#4B5320] dark:focus:ring-[#9acd32] focus:border-transparent transition-colors duration-300">

                <!-- Search Button -->
                <button
                    id="searchButton"
                    class="flex items-center justify-center px-4 bg-[#4B5320] text-white rounded-r-lg hover:bg-[#2F4F4F] transition-all duration-200 focus:ring-2 focus:ring-offset-1 focus:ring-[#4B5320]">
                    <svg class="h-6 w-6 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span class="hidden sm:inline ml-2 font-medium">@t('Cari')</span>
                </button>
            </div>

            <!-- Auto-suggestion Results -->
            <div id="searchResults" class="absolute left-0 right-0 mt-1 bg-white rounded-lg shadow-lg border border-gray-100 z-10 hidden">
                <!-- Results will be populated via JavaScript -->
            </div>
        </div>

        <!-- Category Filter -->
        <div class="w-full md:w-48">
            <select id="categoryFilter" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-[#4B5320] dark:focus:ring-[#9acd32] focus:border-transparent transition-colors duration-300">
                <option value="">@t('Semua Kategori')</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Rating Filter -->
        <div class="w-full md:w-48">
            <select id="ratingFilter" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-[#4B5320] dark:focus:ring-[#9acd32] focus:border-transparent transition-colors duration-300">
                <option value="">@t('Semua Rating')</option>
                <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>⭐ @t('5 Bintang')</option>
                <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>⭐ @t('4+ Bintang')</option>
                <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>⭐ @t('3+ Bintang')</option>
                <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>⭐ @t('2+ Bintang')</option>
                <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>⭐ @t('1+ Bintang')</option>
            </select>
        </div>

        <!-- Sort Options -->
        <div class="w-full md:w-48">
            <select id="sortBooks" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-[#4B5320] dark:focus:ring-[#9acd32] focus:border-transparent transition-colors duration-300">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>@t('Terbaru')</option>
                <option value="terlaris" {{ request('sort') == 'terlaris' ? 'selected' : '' }}>@t('Terlaris')</option>
                <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>@t('Termurah')</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>@t('Termahal')</option>
                <option value="rating_high" {{ request('sort') == 'rating_high' ? 'selected' : '' }}>@t('Rating Tertinggi')</option>
                <option value="rating_low" {{ request('sort') == 'rating_low' ? 'selected' : '' }}>@t('Rating Terendah')</option>
                <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>A-Z</option>
                <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Z-A</option>
            </select>
        </div>
    </div>
</div>

<!-- Books Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($books as $index => $book)
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
        <div class="aspect-[3/4] bg-[#F5F5F5] dark:bg-gray-700 overflow-hidden relative group">
            @if($book->cover_url && $book->cover_url !== 'storage/covers/default.jpg')
            <img src="{{ $book->cover_url }}"
                alt="{{ $book->title }}"
                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
            @else
            <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-[#4B5320] to-[#2F4F4F] dark:from-gray-700 dark:to-gray-800">
                <svg class="w-20 h-20 text-white/70 dark:text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <p class="text-white/90 dark:text-gray-300 text-sm font-medium text-center px-4">{{ Str::limit($book->title, 40) }}</p>
            </div>
            @endif
            
            <!-- Wishlist Heart Button -->
            @if(config('features.wishlist'))
            @auth
            @php
                $isInWishlist = in_array($book->id, $wishlistBookIds);
            @endphp
            <form action="{{ route('wishlist.toggle', $book->id) }}" method="POST" class="absolute top-3 right-3">
                @csrf
                <button type="submit" class="w-10 h-10 rounded-full bg-white/90 backdrop-blur-sm shadow-md flex items-center justify-center hover:bg-white transition-all group/heart">
                    <svg class="w-5 h-5 {{ $isInWishlist ? 'text-red-500 fill-current' : 'text-gray-400' }} group-hover/heart:scale-110 transition-transform" viewBox="0 0 20 20" fill="{{ $isInWishlist ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </form>
            @endauth
            @endif
        </div>
        <div class="p-6">
            <div class="flex gap-2 flex-wrap mb-3">
                @foreach($book->categories as $category)
                <span class="text-xs px-2 py-1 bg-[#F5F5F5] dark:bg-gray-700 text-[#4B5320] dark:text-[#9acd32] rounded-full">
                    {{ $category->name }}
                </span>
                @endforeach
            </div>
            <h3 class="text-lg font-medium text-[#2F4F4F] dark:text-gray-100 mb-1">{{ $book->title }}</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-2">{{ $book->author }}</p>
            
            <!-- Rating Display -->
            @php
                $avgRating = round($book->averageRating(), 1);
                $reviewCount = $book->reviewsCount();
            @endphp
            @if($reviewCount > 0)
            <div class="flex items-center gap-2 mb-3">
                <div class="flex items-center">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($avgRating))
                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        @else
                            <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        @endif
                    @endfor
                </div>
                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $avgRating }} ({{ $reviewCount }})</span>
            </div>
            @else
            <div class="flex items-center gap-2 mb-3">
                <span class="text-sm text-gray-400 dark:text-gray-500">@t('Belum ada ulasan')</span>
            </div>
            @endif
            
            <div class="flex items-center justify-between">
                <div class="text-[#2F4F4F] dark:text-gray-100 font-semibold">Rp {{ number_format($book->price, 0, ',', '.') }}</div>
                <a href="{{ route('books.show', $book->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 rounded-lg hover:bg-[#2F4F4F] dark:hover:bg-[#7ab32e] transition-colors">
                    <span>@t('Detail')</span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-12">
        <div class="w-16 h-16 bg-[#F5F5F5] dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-[#4B5320] dark:text-[#9acd32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
        </div>
        <h3 class="text-lg font-medium text-[#2F4F4F] dark:text-gray-100 mb-2">@t('Tidak Ada Buku')</h3>
        <p class="text-gray-600 dark:text-gray-400">@t('Maaf, tidak ada buku yang sesuai dengan kriteria pencarian Anda.')</p>
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-8">
    {{ $books->links() }}
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchBooks');
        const searchButton = document.getElementById('searchButton');
        const searchResults = document.getElementById('searchResults');
        const categoryFilter = document.getElementById('categoryFilter');
        const ratingFilter = document.getElementById('ratingFilter');
        const sortSelect = document.getElementById('sortBooks');
        let searchTimeout;
        
        // Update URL and reload page with new parameters
        function updateSearch(params = {}) {
            const url = new URL(window.location);
            Object.entries(params).forEach(([key, value]) => {
                if (value) {
                    url.searchParams.set(key, value);
                } else {
                    url.searchParams.delete(key);
                }
            });
            window.location = url;
        }
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Hindari submit form default
                const query = this.value.trim();
                if (query.length >= 2) {
                    updateSearch({
                        search: query
                    });
                }
            }
        });

        // Handle search button click
        searchButton.addEventListener('click', function() {
            const query = searchInput.value.trim();
            if (query.length >= 2) {
                updateSearch({
                    search: query
                });
            }
        });


        // Handle category filter change
        categoryFilter.addEventListener('change', function() {
            updateSearch({
                category: this.value
            });
        });

        // Handle rating filter change
        ratingFilter.addEventListener('change', function() {
            updateSearch({
                rating: this.value
            });
        });

        // Handle sort selection change
        sortSelect.addEventListener('change', function() {
            updateSearch({
                sort: this.value
            });
        });

        // Handle search input with debounce
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length < 2) {
                searchResults.classList.add('hidden');
                return;
            }

            searchTimeout = setTimeout(() => {
                // Show loading state
                searchResults.innerHTML = '<div class="p-3 text-center text-gray-500 dark:text-gray-400"><svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>';
                searchResults.classList.remove('hidden');

                fetch(`/books/suggest?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            searchResults.innerHTML = data.map(book => `
                                <div class="p-3 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer border-b border-gray-100 dark:border-gray-700 last:border-0 transition-colors" onclick="selectBook('${book.title.replace(/'/g, "\\'")}')">
                                    <div class="font-medium text-[#2F4F4F] dark:text-gray-100">${escapeHtml(book.title)}</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">${escapeHtml(book.author)}</div>
                                    ${book.isbn ? `<div class="text-xs text-gray-500 dark:text-gray-500 mt-1">ISBN: ${escapeHtml(book.isbn)}</div>` : ''}
                                </div>
                            `).join('');
                            searchResults.classList.remove('hidden');
                        } else {
                            searchResults.innerHTML = '<div class="p-4 text-center text-gray-500 dark:text-gray-400 text-sm">@t("Tidak ada hasil ditemukan")</div>';
                            searchResults.classList.remove('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching suggestions:', error);
                        searchResults.innerHTML = '<div class="p-4 text-center text-red-500 text-sm">@t("Terjadi kesalahan")</div>';
                    });
            }, 300);
        });

        // Helper function to escape HTML
        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, m => map[m]);
        }

        // Select book from suggestions
        window.selectBook = function(title) {
            searchInput.value = title;
            searchResults.classList.add('hidden');
            updateSearch({search: title});
        };

        // Hide search results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });
    });
</script>
@endpush