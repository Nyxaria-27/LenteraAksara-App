@extends('layouts.app')

@section('title', 'Manajemen Review - Lentera Aksara')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Manage Reviews</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Kelola semua ulasan buku dari pengguna</p>
        </div>
        <div class="text-sm text-gray-600 dark:text-gray-400">
            Total Reviews: <span class="font-semibold text-gray-800 dark:text-white">{{ $reviews->total() }}</span>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="{{ route('admin.reviews.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cari</label>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Nama user atau komentar..."
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#4B5320] focus:border-transparent dark:bg-gray-700 dark:text-white">
            </div>

            <!-- Filter by Book -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Buku</label>
                <select name="book_id" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#4B5320] focus:border-transparent dark:bg-gray-700 dark:text-white">
                    <option value="">Semua Buku</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ request('book_id') == $book->id ? 'selected' : '' }}>
                            {{ Str::limit($book->title, 40) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter by Rating -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Rating</label>
                <select name="rating" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#4B5320] focus:border-transparent dark:bg-gray-700 dark:text-white">
                    <option value="">Semua Rating</option>
                    <option value="5" {{ request('rating') == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5)</option>
                    <option value="4" {{ request('rating') == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4)</option>
                    <option value="3" {{ request('rating') == 3 ? 'selected' : '' }}>⭐⭐⭐ (3)</option>
                    <option value="2" {{ request('rating') == 2 ? 'selected' : '' }}>⭐⭐ (2)</option>
                    <option value="1" {{ request('rating') == 1 ? 'selected' : '' }}>⭐ (1)</option>
                </select>
            </div>

            <!-- Actions -->
            <div class="flex items-end gap-2">
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-[#4B5320] text-white rounded-lg hover:bg-opacity-90 transition font-medium">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'book_id', 'rating']))
                <a href="{{ route('admin.reviews.index') }}" 
                   class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Reviews Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            User & Buku
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Rating
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Komentar
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($reviews as $review)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $review->user->name }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $review->user->email }}
                                    </div>
                                    <a href="{{ route('books.show', $review->book->id) }}" 
                                       target="_blank"
                                       class="text-xs text-[#4B5320] dark:text-[#9acd32] hover:underline mt-1 inline-block">
                                        📚 {{ Str::limit($review->book->title, 30) }}
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400 fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endfor
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $review->rating }}/5</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($review->comment)
                                <p class="text-sm text-gray-700 dark:text-gray-300 line-clamp-2">{{ $review->comment }}</p>
                            @else
                                <p class="text-sm text-gray-400 italic">Tidak ada komentar</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <div>{{ $review->created_at->format('d M Y') }}</div>
                            <div class="text-xs">{{ $review->created_at->format('H:i') }}</div>
                            <div class="text-xs text-gray-400 mt-1">{{ $review->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('books.show', $review->book->id) }}" 
                                   target="_blank"
                                   class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                                   title="Lihat Buku">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('reviews.destroy', $review->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus review ini?')"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                            title="Hapus Review">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                            <p class="text-lg font-medium">Tidak ada review ditemukan</p>
                            @if(request()->hasAny(['search', 'book_id', 'rating']))
                            <p class="text-sm mt-2">Coba ubah filter pencarian Anda</p>
                            <a href="{{ route('admin.reviews.index') }}" 
                               class="inline-block mt-4 px-4 py-2 bg-[#4B5320] text-white rounded-lg hover:bg-opacity-90 transition">
                                Reset Filter
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($reviews->hasPages())
        <div class="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700">
            {{ $reviews->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-6">
        <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-lg shadow-md p-4 text-white">
            <div class="text-2xl font-bold">⭐⭐⭐⭐⭐</div>
            <div class="text-sm opacity-90 mt-1">5 Stars</div>
            <div class="text-2xl font-bold mt-2">{{ $reviews->where('rating', 5)->count() }}</div>
        </div>

        <div class="bg-gradient-to-br from-green-400 to-green-500 rounded-lg shadow-md p-4 text-white">
            <div class="text-2xl font-bold">⭐⭐⭐⭐</div>
            <div class="text-sm opacity-90 mt-1">4 Stars</div>
            <div class="text-2xl font-bold mt-2">{{ $reviews->where('rating', 4)->count() }}</div>
        </div>

        <div class="bg-gradient-to-br from-blue-400 to-blue-500 rounded-lg shadow-md p-4 text-white">
            <div class="text-2xl font-bold">⭐⭐⭐</div>
            <div class="text-sm opacity-90 mt-1">3 Stars</div>
            <div class="text-2xl font-bold mt-2">{{ $reviews->where('rating', 3)->count() }}</div>
        </div>

        <div class="bg-gradient-to-br from-orange-400 to-orange-500 rounded-lg shadow-md p-4 text-white">
            <div class="text-2xl font-bold">⭐⭐</div>
            <div class="text-sm opacity-90 mt-1">2 Stars</div>
            <div class="text-2xl font-bold mt-2">{{ $reviews->where('rating', 2)->count() }}</div>
        </div>

        <div class="bg-gradient-to-br from-red-400 to-red-500 rounded-lg shadow-md p-4 text-white">
            <div class="text-2xl font-bold">⭐</div>
            <div class="text-sm opacity-90 mt-1">1 Star</div>
            <div class="text-2xl font-bold mt-2">{{ $reviews->where('rating', 1)->count() }}</div>
        </div>
    </div>
</div>
@endsection
