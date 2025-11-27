@extends('layouts.app')

@section('title', 'Lentera Aksara - Beranda')

@section('fullbleed')
<!-- HERO (full-bleed) -->
<section aria-label="Hero" class="w-full">
    <div class="relative h-screen min-h-[520px] flex items-center">
        <!-- Background image + subtle overlay -->
        <img src="{{ asset('hero.jpg') }}" alt="" class="absolute inset-0 w-full h-full object-cover" />
        <div class="absolute inset-0 hero-gradient"></div>

        <div class="container mx-auto relative z-10 px-6 lg:px-10">
            <div class="max-w-3xl text-left">
                <span class="inline-block px-3 py-1 mb-4 rounded-full text-sm font-medium bg-[#D2B48C] dark:bg-[#8b7355] text-[#2F4F4F] dark:text-gray-100" {!! aos('fade-down') !!}>Lentera Aksara</span>
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-serif leading-tight text-white drop-shadow-md" {!! aos('fade-up', 100) !!}>@t('Temukan Dunia Dalam Buku')</h1>
                <p class="mt-6 text-lg sm:text-xl text-gray-100 max-w-xl" {!! aos('fade-up', 200) !!}>@t('Jelajahi koleksi buku pilihan kami dan temukan bacaan yang menginspirasi perjalanan literasi Anda')</p>

                <div class="mt-8 flex flex-wrap gap-4" {!! aos('fade-up', 300) !!}>
                    @auth
                    @if (auth()->user()->role === 'user')
                    <a href="{{ route('books.index') }}" class="inline-flex items-center gap-3 px-6 py-3 rounded-2xl font-semibold shadow-sm bg-[#4B5320] dark:bg-[#9acd32] text-[#F5F5F5] dark:text-gray-900 hover:bg-[#2F4F4F] dark:hover:bg-[#7ab32e] transition-colors">@t('Jelajahi Buku')</a>
                    @elseif (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-3 px-6 py-3 rounded-2xl font-semibold shadow-sm bg-red-700 dark:bg-red-600 text-white hover:bg-red-800 dark:hover:bg-red-700 transition-colors">@t('Dashboard Admin')</a>
                    @endif
                    @else
                    <a href="{{ route('books.index') }}" class="inline-flex items-center gap-3 px-6 py-3 rounded-2xl font-semibold shadow-sm bg-[#4B5320] dark:bg-[#9acd32] text-[#F5F5F5] dark:text-gray-900 hover:bg-[#2F4F4F] dark:hover:bg-[#7ab32e] transition-colors">@t('Jelajahi Buku')</a>
                    @endauth
                    <a href="#about" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl border border-white/30 text-white/90 hover:bg-white/10 transition-colors">@t('Tentang')</a>
                </div>

                <!-- Quick search / mini-filter -->
                @auth
                @if (auth()->user()->role === 'user')
                <form action="{{ route('books.index') }}" method="GET" class="mt-8 bg-white/10 dark:bg-gray-900/30 backdrop-blur-sm p-3 rounded-xl max-w-md" {!! aos('fade-up', 400) !!}>
                    <div class="flex items-center gap-3">
                        <input name="search" placeholder="@t('Cari judul, penulis, atau ISBN...')" class="flex-1 bg-transparent outline-none placeholder-gray-200 dark:placeholder-gray-400 text-white" />
                        <button class="px-4 py-2 rounded-lg font-medium bg-[#D2B48C] dark:bg-[#8b7355] text-[#2F4F4F] dark:text-gray-100 hover:bg-[#c9a574] dark:hover:bg-[#6d5a43] transition-colors">@t('Cari')</button>
                    </div>
                </form>
                @endif
                @endif

                <!-- Micro statistics -->
                <div class="mt-6 flex flex-wrap gap-6 text-sm text-gray-200" {!! aos('fade-up', 500) !!}>
                    <div>
                        <div class="text-2xl font-semibold">1.2K+</div>
                        <div class="text-xs text-gray-300">@t('Judul Terdaftar')</div>
                    </div>
                    <div>
                        <div class="text-2xl font-semibold">320+</div>
                        <div class="text-xs text-gray-300">@t('Penulis Terdaftar')</div>
                    </div>
                    <div>
                        <div class="text-2xl font-semibold">8+</div>
                        <div class="text-xs text-gray-300">@t('Kategori Terpilih')</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<!-- ABOUT (Hidden for Admin, Visible for User & Guest) -->
@if(!auth()->check() || auth()->user()->role !== 'admin')
<section id="about" aria-label="About Lentera Aksara" class="py-20 bg-gradient-to-b from-white dark:from-gray-900 to-gray-50 dark:to-gray-800 transition-colors duration-300">
    <div class="container mx-auto px-6 lg:px-10">
        <div class="text-center mb-12" {!! aos('fade-up') !!}>
            <h2 class="text-4xl font-serif text-[#2F4F4F] dark:text-gray-100 mb-4">{{ $about->title ?? '@t("Tentang Kami")' }}</h2>
            <div class="w-20 h-1 bg-[#4B5320] dark:bg-[#9acd32] mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Image -->
            <div class="order-1 lg:order-2" {!! aos('fade-left', 100) !!}>
                <div class="rounded-2xl overflow-hidden shadow-2xl dark:shadow-gray-900/50 transform hover:scale-105 transition-transform duration-300">
                    @if($about && $about->image)
                    <img src="{{ asset('storage/' . $about->image) }}" alt="{{ $about->title }}" class="w-full h-96 object-cover" />
                    @else
                    <img src="{{ asset('Library.jpg') }}" alt="Tentang Lentera Aksara" class="w-full h-96 object-cover" />
                    @endif
                </div>
            </div>

            <!-- Content with Read More/Less -->
            <div class="order-2 lg:order-1" {!! aos('fade-right', 100) !!}>
                <div class="prose prose-lg max-w-none">
                    @if($about && $about->content)
                    <div id="aboutContent" class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        <!-- Preview (first 300 characters) -->
                        <div id="aboutPreview">
                            {!! \Illuminate\Support\Str::limit(strip_tags(\App\Helpers\TranslatorHelper::translate($about->content, app()->getLocale())), 300, '...') !!}
                        </div>

                        <!-- Full Content (hidden by default) -->
                        <div id="aboutFull" class="hidden">
                            {!! \App\Helpers\TranslatorHelper::translate($about->content, app()->getLocale()) !!}
                        </div>
                    </div>

                    <!-- Read More/Less Button -->
                    <button id="toggleAbout"
                        onclick="toggleAboutContent()"
                        class="mt-6 inline-flex items-center gap-2 px-6 py-2.5 rounded-lg font-medium bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 hover:bg-[#3a4019] dark:hover:bg-[#7ab32e] transition-colors">
                        <span id="toggleText">@t('Baca Selengkapnya')</span>
                        <svg id="toggleIcon" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    @else
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        @t('Lentera Aksara adalah sebuah toko buku daring yang mengusung filosofi "Tranquil Growth" — yaitu ruang bagi pembaca yang mencari bacaan berkualitas dalam suasana yang tenang dan penuh perenungan.')
                    </p>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex flex-wrap gap-4">
                    @auth
                    @if (auth()->user()->role === 'user')
                    <a href="{{ route('books.index') }}" class="px-6 py-3 rounded-lg font-medium bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 hover:shadow-lg transition-all">
                        @t('Jelajahi Buku')
                    </a>
                    <a href="{{ route('user.contact.index') }}" class="px-6 py-3 rounded-lg border-2 border-[#4B5320] dark:border-[#9acd32] text-[#4B5320] dark:text-[#9acd32] hover:bg-[#4B5320] dark:hover:bg-[#9acd32] hover:text-white dark:hover:text-gray-900 transition-colors">
                        @t('Hubungi Kami')
                    </a>
                    @elseif (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.about.edit') }}" class="px-6 py-3 rounded-lg font-medium bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 hover:shadow-lg transition-all">
                        @t('Edit Tentang')
                    </a>
                    @endif
                    @else
                    <a href="{{ route('books.index') }}" class="px-6 py-3 rounded-lg font-medium bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 hover:shadow-lg transition-all">
                        @t('Jelajahi Buku')
                    </a>
                    <a href="{{ route('login') }}" class="px-6 py-3 rounded-lg border-2 border-[#4B5320] dark:border-[#9acd32] text-[#4B5320] dark:text-[#9acd32] hover:bg-[#4B5320] dark:hover:bg-[#9acd32] hover:text-white dark:hover:text-gray-900 transition-colors">
                        @t('Login')
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<script>
    function toggleAboutContent() {
        const preview = document.getElementById('aboutPreview');
        const full = document.getElementById('aboutFull');
        const toggleText = document.getElementById('toggleText');
        const toggleIcon = document.getElementById('toggleIcon');

        if (full.classList.contains('hidden')) {
            // Show full content
            preview.classList.add('hidden');
            full.classList.remove('hidden');
            toggleText.textContent = '@t("Baca Lebih Sedikit")';
            toggleIcon.style.transform = 'rotate(180deg)';
        } else {
            // Show preview
            preview.classList.remove('hidden');
            full.classList.add('hidden');
            toggleText.textContent = '@t("Baca Selengkapnya")';
            toggleIcon.style.transform = 'rotate(0deg)';

            // Smooth scroll to about section
            document.getElementById('about').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }
</script>

<!-- BOOKS PREVIEW with Pagination -->
<section aria-label="Koleksi Buku Terbaru" class="py-20 bg-white dark:bg-gray-900 transition-colors duration-300">
    <div class="container mx-auto px-6 lg:px-10">
        <div class="text-center mb-12" {!! aos('fade-up') !!}>
            <h2 class="text-4xl font-serif text-[#2F4F4F] dark:text-gray-100 mb-4">@t('Koleksi Buku Terbaru')</h2>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">@t('Temukan buku-buku terbaru yang telah kami kurasi khusus untuk Anda')</p>
            <div class="w-20 h-1 bg-[#4B5320] dark:bg-[#9acd32] mx-auto rounded-full mt-4"></div>
        </div>

        <!-- Books Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-12">
            @forelse($books as $index => $book)
            <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-2xl dark:shadow-gray-900/50 transition-all duration-300 overflow-hidden" {!! aos('fade-up', $index * 50) !!}>
                <!-- Book Image -->
                <div class="relative overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 h-80 flex items-center justify-center p-4">
                    @if($book->cover_image)
                    <div class="relative w-full h-full group-hover:scale-105 transition-transform duration-500">
                        <img src="{{ asset('storage/' . $book->cover_image) }}"
                            alt="{{ $book->title }}"
                            class="w-full h-full object-contain drop-shadow-2xl">
                        <!-- Subtle overlay on hover -->
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors duration-300 rounded"></div>
                    </div>
                    @else
                    <div class="w-3/4 h-full flex flex-col items-center justify-center bg-gradient-to-br from-[#4B5320] to-[#2F4F4F] dark:from-[#9acd32] dark:to-[#7ab32e] text-white dark:text-gray-900 rounded-lg shadow-xl p-6">
                        <svg class="w-20 h-20 opacity-30 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <div class="text-center space-y-2">
                            <p class="text-[10px] font-semibold opacity-60 uppercase tracking-wider">@t('Cover Tidak Tersedia')</p>
                            <p class="text-xs font-medium opacity-80 px-2 line-clamp-2">{{ $book->title }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Stock Badge with better positioning -->
                    @if($book->stock > 0)
                    <span class="absolute top-3 right-3 px-3 py-1.5 bg-green-500 text-white text-xs font-semibold rounded-full shadow-lg backdrop-blur-sm bg-opacity-90">
                        @t('Stok'): {{ $book->stock }}
                    </span>
                    @else
                    <span class="absolute top-3 right-3 px-3 py-1.5 bg-red-500 text-white text-xs font-semibold rounded-full shadow-lg backdrop-blur-sm bg-opacity-90">
                        @t('Habis')
                    </span>
                    @endif
                </div>

                <!-- Book Info -->
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 text-sm mb-1 line-clamp-2 min-h-[40px]">
                        {{ $book->title }}
                    </h3>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">{{ $book->author }}</p>

                    <!-- Categories -->
                    @if($book->categories && $book->categories->count() > 0)
                    <div class="flex flex-wrap gap-1 mb-3">
                        @foreach($book->categories->take(2) as $category)
                        <span class="px-2 py-0.5 bg-[#F5F5F5] dark:bg-gray-700 text-[#4B5320] dark:text-[#9acd32] text-xs rounded">
                            {{ $category->name }}
                        </span>
                        @endforeach
                    </div>
                    @endif

                    @if(config('features.reviews'))
                    <!-- Rating Display -->
                    @php
                        $avgRating = round($book->averageRating(), 1);
                        $reviewCount = $book->reviewsCount();
                    @endphp
                    @if($reviewCount > 0)
                    <div class="flex items-center gap-1 mb-2">
                        <div class="flex">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($avgRating))
                                    <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @else
                                    <svg class="w-3 h-3 text-gray-300 dark:text-gray-600 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="text-xs text-gray-600 dark:text-gray-400">{{ $avgRating }} ({{ $reviewCount }})</span>
                    </div>
                    @endif
                    @endif

                    <!-- Price -->
                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100 dark:border-gray-700">
                        <span class="text-lg font-bold text-[#2F4F4F] dark:text-gray-100">
                            Rp {{ number_format($book->price, 0, ',', '.') }}
                        </span>

                        @auth
                        @if(auth()->user()->role === 'user')
                        <a href="{{ route('books.show', $book->id) }}"
                            class="px-3 py-1.5 bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 text-xs font-medium rounded-lg hover:bg-[#3a4019] dark:hover:bg-[#7ab32e] transition-colors">
                            @t('Detail')
                        </a>
                        @endif
                        @else
                        <a href="{{ route('login') }}"
                            class="px-3 py-1.5 bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 text-xs font-medium rounded-lg hover:bg-[#3a4019] dark:hover:bg-[#7ab32e] transition-colors">
                            @t('Login')
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <svg class="w-20 h-20 mx-auto text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">@t('Belum Ada Buku')</h3>
                <p class="text-gray-500 dark:text-gray-400">@t('Koleksi buku akan segera hadir')</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($books->hasPages())
        <div class="flex flex-col">
            <div class="inline-flex flex-col justify-between space-x-1 bg-white dark:bg-gray-800 shadow-md rounded-lg p-2">
                {{ $books->links() }}
            </div>
        </div>
        @endif

        <!-- View All Button -->
        <div class="text-center mt-8">
            <a href="{{ route('books.index') }}"
                class="inline-flex items-center gap-2 px-8 py-3 bg-[#4B5320] text-white font-semibold rounded-lg hover:bg-[#3a4019] hover:shadow-lg transition-all">
                <span>@t('Lihat Semua Buku')</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- FEATURE / HIGHLIGHTS -->
<section aria-label="Highlights" class="py-14 bg-gray-50 dark:bg-gray-800 transition-colors duration-300">
    <div class="container mx-auto px-6 lg:px-10">
        <h3 class="text-2xl font-serif text-[#2F4F4F] dark:text-gray-100" {!! aos('fade-up') !!}>@t('Kenapa Memilih Kami')</h3>
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="p-6 rounded-xl bg-[#F8F5F2] dark:bg-gray-700 transition-colors duration-300" {!! aos('fade-up', 0) !!}>
                <h4 class="font-semibold text-lg text-gray-900 dark:text-gray-100">@t('Koleksi Terkurasi')</h4>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">@t('Hanya judul berkualitas yang masuk ke kurasi kami.')</p>
            </div>
            <div class="p-6 rounded-xl bg-white dark:bg-gray-800 border dark:border-gray-700 transition-colors duration-300" {!! aos('fade-up', 100) !!}>
                <h4 class="font-semibold text-lg text-gray-900 dark:text-gray-100">@t('Pengiriman Aman')</h4>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">@t('Pembungkusan ramah lingkungan dan cepat sampai.')</p>
            </div>
            <div class="p-6 rounded-xl bg-[#F8F5F2] dark:bg-gray-700 transition-colors duration-300" {!! aos('fade-up', 200) !!}>
                <h4 class="font-semibold text-lg text-gray-900 dark:text-gray-100">@t('Rekomendasi Personal')</h4>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">@t('Fitur rekomendasi yang menyesuaikan selera membaca Anda.')</p>
            </div>
            <div class="p-6 rounded-xl bg-white dark:bg-gray-800 border dark:border-gray-700 transition-colors duration-300" {!! aos('fade-up', 300) !!}>
                <h4 class="font-semibold text-lg text-gray-900 dark:text-gray-100">@t('Acara & Klub')</h4>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">@t('Komunitas baca dan acara tematik rutin.')</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA BOTTOM -->
<section aria-label="Call to action" class="py-12 bg-[#F5F5F5] dark:bg-gray-900 transition-colors duration-300">
    <div class="container mx-auto px-6 lg:px-10 text-center" {!! aos('zoom-in') !!}>
        <h4 class="text-xl font-serif text-[#2F4F4F] dark:text-gray-100">@t('Siap Menemukan Buku Berikutnya?')</h4>
        <p class="mt-3 text-gray-600 dark:text-gray-400">@t('Jelajahi koleksi kami yang terus berkembang — temukan bacaan yang akan menumbuhkan pikiran dan hati Anda.')</p>
        <div class="mt-6">
            <a href="{{ route('books.index') }}" class="inline-block px-6 py-3 rounded-2xl font-semibold bg-[#4B5320] dark:bg-[#9acd32] text-[#F5F5F5] dark:text-gray-900 hover:bg-[#2F4F4F] dark:hover:bg-[#7ab32e] transition-colors">@t('Mulai Menjelajah')</a>
        </div>
    </div>
</section>

@endsection