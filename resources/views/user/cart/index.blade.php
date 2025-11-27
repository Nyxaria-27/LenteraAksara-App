@extends('layouts.app')
@section('title', 'Keranjang Belanja - Lentera Aksara')

@section('content')
<!-- Breadcrumbs -->
<nav class="text-gray-600 dark:text-gray-400 text-sm mb-6 transition-colors duration-300" aria-label="Breadcrumb">
    <ol class="list-none p-0 flex items-center space-x-2">
        <li><a href="{{ route('welcome') }}" class="hover:text-[#4B5320] dark:hover:text-[#9acd32] transition-colors">@t('Beranda')</a></li>
        <li class="flex items-center space-x-2">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-[#2F4F4F] dark:text-gray-100">@t('Keranjang')</span>
        </li>
    </ol>
</nav>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl md:text-4xl font-serif text-[#2F4F4F] dark:text-gray-100">@t('Keranjang Belanja')</h1>
    <p class="text-gray-600 dark:text-gray-400 mt-2">@t('Kelola buku yang akan Anda beli')</p>
</div>

<!-- Alerts -->
@if(session('success'))
    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-400 dark:border-green-500 rounded-lg animate-fade-in transition-colors duration-300">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-green-400 dark:text-green-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="text-green-800 dark:text-green-200">{{ session('success') }}</span>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-400 dark:border-red-500 rounded-lg animate-fade-in transition-colors duration-300">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-red-400 dark:text-red-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-red-800 dark:text-red-200">{{ session('error') }}</span>
        </div>
    </div>
@endif

@if($items->count() > 0)
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Cart Items -->
    <div class="lg:col-span-2 space-y-4">
        @foreach($items as $item)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">
            <div class="flex flex-col sm:flex-row gap-4 p-4 sm:p-6">
                <!-- Book Cover -->
                <div class="flex-shrink-0">
                    <div class="w-full sm:w-24 h-32 sm:h-32 bg-[#F5F5F5] dark:bg-gray-700 rounded-lg overflow-hidden">
                        <img src="{{ $item->book->cover ? asset('storage/' . $item->book->cover) : 'https://placehold.co/240x320?text=No+Cover' }}" 
                             alt="{{ $item->book->title }}" 
                             class="w-full h-full object-cover">
                    </div>
                </div>

                <!-- Book Details -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex-1 pr-4">
                            <h3 class="text-lg font-medium text-[#2F4F4F] dark:text-gray-100 mb-1">{{ $item->book->title }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $item->book->author }}</p>
                            
                            @if($item->book->categories->count() > 0)
                            <div class="flex gap-2 mt-2 flex-wrap">
                                @foreach($item->book->categories as $category)
                                    <span class="text-xs px-2 py-1 bg-[#F5F5F5] dark:bg-gray-700 text-[#4B5320] dark:text-[#9acd32] rounded-full">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        
                        <!-- Price -->
                        <div class="text-right flex-shrink-0">
                            <div class="text-lg font-semibold text-[#2F4F4F] dark:text-gray-100">
                                Rp {{ number_format($item->book->price, 0, ',', '.') }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                @t('Stok'): {{ $item->book->stock }}
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <!-- Quantity Controls -->
                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PUT')
                            <label class="text-sm text-gray-600 dark:text-gray-400 mr-2">@t('Jumlah'):</label>
                            <div class="flex items-center border border-gray-200 dark:border-gray-600 rounded-lg">
                                <button type="button" 
                                        onclick="decrementQty('{{ $item->id }}')" 
                                        class="px-3 py-1 hover:bg-[#F5F5F5] dark:hover:bg-gray-700 transition-colors">
                                    <svg class="w-4 h-4 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <input type="number" 
                                       id="qty-{{ $item->id }}"
                                       name="quantity" 
                                       value="{{ $item->quantity }}" 
                                       min="1" 
                                       max="{{ $item->book->stock }}"
                                       class="w-16 text-center border-0 focus:ring-0 py-1 bg-transparent dark:text-gray-100">
                                <button type="button" 
                                        onclick="incrementQty({{ $item->id }}, {{ $item->book->stock }})" 
                                        class="px-3 py-1 hover:bg-[#F5F5F5] dark:hover:bg-gray-700 transition-colors">
                                    <svg class="w-4 h-4 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                            <button type="submit" 
                                    class="px-4 py-2 bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 text-sm rounded-lg hover:bg-[#2F4F4F] dark:hover:bg-[#7ab32e] transition-colors">
                                @t('Update')
                            </button>
                        </form>

                        <!-- Remove Button -->
                        <button type="button" 
                                onclick="confirmRemove({{ $item->id }}, '{{ addslashes($item->book->title) }}')"
                                class="flex items-center gap-2 text-red-600 hover:text-red-700 transition-colors text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            @t('Hapus')
                        </button>

                        <form id="remove-form-{{ $item->id }}" 
                              action="{{ route('cart.destroy', $item->id) }}" 
                              method="POST" 
                              class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>

                    <!-- Subtotal -->
                    <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">@t('Subtotal'):</span>
                            <span class="text-lg font-semibold text-[#4B5320] dark:text-[#9acd32]">
                                Rp {{ number_format($item->book->price * $item->quantity, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Order Summary -->
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 sticky top-4 transition-colors duration-300">
            <h2 class="text-xl font-serif text-[#2F4F4F] dark:text-gray-100 mb-6">@t('Ringkasan Pesanan')</h2>
            
            <div class="space-y-3 mb-6">
                <div class="flex justify-between text-gray-600 dark:text-gray-400">
                    <span>@t('Subtotal') ({{ $items->count() }} @t('item'))</span>
                    <span>Rp {{ number_format($items->sum(function($item) { return $item->book->price * $item->quantity; }), 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-gray-600 dark:text-gray-400">
                    <span>@t('Biaya Pengiriman')</span>
                    <span class="text-green-600 dark:text-green-400">@t('Gratis')</span>
                </div>
                <div class="border-t border-gray-200 dark:border-gray-700 pt-3 mt-3">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-[#2F4F4F] dark:text-gray-100">@t('Total')</span>
                        <span class="text-2xl font-bold text-[#4B5320] dark:text-[#9acd32]">
                            Rp {{ number_format($items->sum(function($item) { return $item->book->price * $item->quantity; }), 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <a href="{{ route('checkout.index') }}" 
               class="w-full px-6 py-3 bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 rounded-lg hover:bg-[#2F4F4F] dark:hover:bg-[#7ab32e] transition-colors font-medium flex items-center justify-center gap-2">
                <span>@t('Lanjut ke Checkout')</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>

            <a href="{{ route('books.index') }}" 
               class="block w-full mt-3 px-6 py-3 bg-gray-100 dark:bg-gray-700 text-[#2F4F4F] dark:text-gray-100 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors font-medium text-center">
                @t('Lanjut Belanja')
            </a>

            <!-- Trust Badges -->
            <div class="mt-6 pt-6 border-t space-y-3">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-[#4B5320] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <div>
                        <div class="text-sm font-medium text-[#2F4F4F]">@t('Pembayaran Aman')</div>
                        <div class="text-xs text-gray-500">@t('Transaksi terenkripsi')</div>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-[#4B5320] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                    <div>
                        <div class="text-sm font-medium text-[#2F4F4F]">@t('Pengiriman Gratis')</div>
                        <div class="text-xs text-gray-500">@t('Untuk semua pembelian')</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@else
<!-- Empty Cart State -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-12 text-center transition-colors duration-300">
    <div class="w-24 h-24 bg-[#F5F5F5] dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-12 h-12 text-[#4B5320] dark:text-[#9acd32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
        </svg>
    </div>
    <h2 class="text-2xl font-serif text-[#2F4F4F] dark:text-gray-100 mb-2">@t('Keranjang Kosong')</h2>
    <p class="text-gray-600 dark:text-gray-400 mb-8">@t('Belum ada buku dalam keranjang Anda. Mari jelajahi koleksi kami!')</p>
    <a href="{{ route('books.index') }}" 
       class="inline-flex items-center gap-2 px-6 py-3 bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 rounded-lg hover:bg-[#2F4F4F] dark:hover:bg-[#7ab32e] transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
        @t('Jelajahi Buku')
    </a>
</div>
@endif

<!-- Delete Confirmation Modal -->
<div id="removeModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="fixed inset-0 bg-black dark:bg-black bg-opacity-50 dark:bg-opacity-70" onclick="closeRemoveModal()"></div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full mx-4 relative z-10 transition-colors duration-300">
        <div class="p-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-medium text-[#2F4F4F] dark:text-gray-100">@t('Hapus dari Keranjang?')</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1" id="removeModalText"></p>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button onclick="closeRemoveModal()" 
                        class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    @t('Batal')
                </button>
                <button onclick="submitRemove()" 
                        class="px-4 py-2 bg-red-600 dark:bg-red-700 text-white rounded-lg hover:bg-red-700 dark:hover:bg-red-600 transition-colors">
                    @t('Hapus')
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let currentRemoveForm = null;

function incrementQty(itemId, maxStock) {
    const input = document.getElementById('qty-' + itemId);
    const currentVal = parseInt(input.value) || 1;
    if (currentVal < maxStock) {
        input.value = currentVal + 1;
    }
}

function decrementQty(itemId) {
    const input = document.getElementById('qty-' + itemId);
    const currentVal = parseInt(input.value) || 1;
    if (currentVal > 1) {
        input.value = currentVal - 1;
    }
}

function confirmRemove(itemId, bookTitle) {
    currentRemoveForm = document.getElementById('remove-form-' + itemId);
    document.getElementById('removeModalText').textContent = '@t("Apakah Anda yakin ingin menghapus")' + ' "' + bookTitle + '" @t("dari keranjang?")';
    const modal = document.getElementById('removeModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeRemoveModal() {
    const modal = document.getElementById('removeModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
    currentRemoveForm = null;
}

function submitRemove() {
    if (currentRemoveForm) {
        currentRemoveForm.submit();
    }
}

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeRemoveModal();
    }
});
</script>
@endpush
