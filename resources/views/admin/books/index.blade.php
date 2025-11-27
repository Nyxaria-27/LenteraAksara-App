@extends('layouts.app')
@section('title', 'Manajemen Buku - Lentera Aksara')

@push('styles')
<style>
    .cover-preview {
        transition: transform 0.3s ease;
    }
    .cover-preview:hover {
        transform: scale(1.5);
        z-index: 50;
    }
    .fade-enter { opacity: 0; }
    .fade-enter-active { opacity: 1; transition: opacity 200ms ease-in; }
    .fade-exit { opacity: 1; }
    .fade-exit-active { opacity: 0; transition: opacity 200ms ease-out; }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="relative bg-[#4B5320] text-white rounded-xl mb-8 p-6 overflow-hidden">
    <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-serif mb-2">@t('Manajemen Buku')</h1>
            <p class="text-[#F5F5F5] opacity-90">@t('Kelola koleksi buku Lentera Aksara')</p>
        </div>

        <!-- Tombol Tambah Buku: responsive, z-index tinggi agar selalu klikable -->
        <div class="flex-shrink-0">
            <a href="{{ route('admin.books.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2 bg-white text-[#4B5320] rounded-lg hover:bg-[#F5F5F5] transition-all duration-300 z-20 dark:bg-gray-800 transition-colors duration-300 dark:text-gray-100 dark:hover:bg-gray-700">
                <span>@t('Tambah Buku')</span>
                <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </a>
        </div>
    </div>

    <!-- Dekorasi visual, ditaruh di belakang (tidak menutupi tombol karena z-10 dan tombol z-20) -->
    <div class="absolute right-0 top-0 h-full w-64 bg-[#2F4F4F] opacity-20 transform -skew-x-12 pointer-events-none"></div>
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-400 text-green-800 rounded animate-fade-in">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('success') }}
        </div>
    </div>
@endif
@if(session('error'))
    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-400 text-red-800 rounded animate-fade-in">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            {{ session('error') }}
        </div>
    </div>
@endif

<!-- Search and Filter Section -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="md:col-span-2 bg-white rounded-xl shadow-sm p-4 dark:bg-gray-800 transition-colors duration-300">
        <form method="GET" class="flex gap-4" action="{{ route('admin.books.index') }}">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="@t('Cari judul, penulis, ISBN...')"
                    class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#4B5320] focus:border-transparent transition-shadow dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 ">
            </div>
            <button type="submit"
                class="px-6 py-2 bg-[#4B5320] text-white rounded-lg hover:bg-[#2F4F4F] transition-colors duration-300 flex items-center">
                <span>@t('Cari')</span>
            </button>
        </form>
    </div>

    <!-- Form untuk kategori: now correctly enclosed in a form so onchange works -->
    <div class="bg-white rounded-xl shadow-sm p-4 dark:bg-gray-800 transition-colors duration-300">
        <form id="filterForm" method="GET" action="{{ route('admin.books.index') }}">
            {{-- pertahankan search param saat mengganti kategori --}}
            <input type="hidden" name="search" value="{{ request('search') }}">
            <select name="category"
                onchange="document.getElementById('filterForm').submit()"
                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#4B5320] focus:border-transparent transition-shadow dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                <option value="">@t('Semua Kategori')</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
</div>

<!-- Books Table -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden dark:bg-gray-800 transition-colors duration-300">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-[#F5F5F5] dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-[#2F4F4F] dark:text-gray-200">@t('Cover')</th>
                    <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-[#2F4F4F] dark:text-gray-200">@t('Detail Buku')</th>
                    <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-[#2F4F4F] dark:text-gray-200">@t('Kategori')</th>
                    <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-[#2F4F4F] dark:text-gray-200">@t('Harga & Stok')</th>
                    <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-[#2F4F4F] dark:text-gray-200">@t('Aksi')</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($books as $book)
                <tr class="hover:bg-[#F5F5F5] dark:hover:bg-gray-700 transition-colors duration-150">
                    <td class="px-6 py-4">
                        <div class="relative group">
                            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://placehold.co/120x160?text=No+Cover' }}"
                                alt="{{ $book->title }}"
                                class="w-16 h-20 object-cover rounded-lg cover-preview cursor-pointer shadow-sm hover:shadow-md transition-shadow"
                                data-cover="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://placehold.co/400x600?text=No+Cover' }}">
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <h3 class="font-medium text-[#2F4F4F] dark:text-gray-100">{{ $book->title }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $book->author }}</p>
                            <span class="text-xs text-gray-500 dark:text-gray-500 mt-1">ISBN: {{ $book->isbn }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-2">
                            @foreach($book->categories as $cat)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#4B5320] dark:bg-[#9acd32] bg-opacity-10 dark:bg-opacity-20 text-[#4B5320] dark:text-[#9acd32]">
                                    {{ $cat->name }}
                                </span>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="text-[#2F4F4F] dark:text-gray-100 font-medium">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                            <span class="text-sm text-gray-600 dark:text-gray-400">@t('Stok'): {{ $book->stock }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.books.edit', $book->id) }}"
                               class="inline-flex items-center justify-center px-3 py-1 bg-[#4B5320] bg-opacity-10 text-[#4B5320] rounded-lg hover:bg-opacity-20 transition-colors dark:bg-[#9acd32] dark:bg-opacity-20 dark:text-[#9acd32] dark:hover:bg-opacity-30">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                @t('Edit')
                            </a>
                            <button type="button"
                                    onclick="confirmDelete('{{ $book->id }}')"
                                    class="inline-flex items-center justify-center px-3 py-1 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors dark:bg-red-900 dark:bg-opacity-20 dark:text-red-400 dark:hover:bg-red-800">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                @t('Hapus')
                            </button>
                            <form id="delete-form-{{ $book->id }}"
                                  action="{{ route('admin.books.destroy', $book->id) }}"
                                  method="POST"
                                  class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">@t('Tidak ada buku')</h3>
                            <p class="mt-1 text-sm text-gray-500">@t('Belum ada buku yang ditambahkan atau sesuai dengan pencarian.')</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.books.create') }}" class="inline-flex items-center px-4 py-2 bg-[#4B5320] text-white rounded-lg hover:bg-[#2F4F4F] transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    @t('Tambah Buku Baru')
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Cover Preview Modal (pindah keluar dari table agar HTML valid) -->
<div id="coverPreviewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="relative bg-white p-2 rounded-lg max-w-2xl mx-auto dark:bg-gray-800 transition-colors duration-300">
        <button onclick="closeCoverPreview()" class="absolute -top-10 right-0 text-white hover:text-gray-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <img id="coverPreviewImage" src="" alt="Book Cover Preview" class="max-h-[80vh] object-contain">
    </div>
</div>

<div class="mt-6">
    {{ $books->links() }}
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cover Preview
    const coverImages = document.querySelectorAll('.cover-preview');
    const modal = document.getElementById('coverPreviewModal');
    const modalImage = document.getElementById('coverPreviewImage');

    coverImages.forEach(img => {
        img.addEventListener('click', function() {
            modalImage.src = this.dataset.cover;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        });
    });

    window.closeCoverPreview = function() {
        if(!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
        modalImage.src = '';
    };

    // Konfirmasi Hapus
    window.confirmDelete = function(bookId) {
        if (confirm('@t("Apakah Anda yakin ingin menghapus buku ini? Tindakan ini tidak dapat dibatalkan.")')) {
            document.getElementById('delete-form-' + bookId).submit();
        }
    };

    // Close modal when clicking outside
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeCoverPreview();
            }
        });
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
            closeCoverPreview();
        }
    });

    // Improve accessibility: allow Enter/Space to open images when focused
    coverImages.forEach(img => {
        img.setAttribute('tabindex', '0');
        img.addEventListener('keydown', function(e){
            if(e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });
});
</script>
@endpush
