@extends('layouts.app')

@php
    use App\Helpers\TranslatorHelper;
@endphp

@section('content')
<div class="min-h-screen bg-[#F5F5F5] py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('user.orders.index') }}" 
               class="inline-flex items-center text-[#4B5320] hover:text-[#2F4F4F] transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                @t('Kembali ke Daftar Pesanan')
            </a>
        </div>

        <!-- Order Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-[#2F4F4F] font-lora mb-1">@t('Detail Pesanan') #{{ $order->id }}</h1>
                    <p class="text-gray-600">@t('Tanggal'): {{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                
                <!-- Status Badge -->
                @php
                    $statusConfig = [
                        'pending' => ['label' => TranslatorHelper::translate('Menunggu Pembayaran'), 'color' => 'bg-yellow-100 text-yellow-800'],
                        'processing' => ['label' => TranslatorHelper::translate('Diproses'), 'color' => 'bg-blue-100 text-blue-800'],
                        'shipped' => ['label' => TranslatorHelper::translate('Dikirim'), 'color' => 'bg-purple-100 text-purple-800'],
                        'completed' => ['label' => TranslatorHelper::translate('Selesai'), 'color' => 'bg-green-100 text-green-800']
                    ];
                    $status = $statusConfig[$order->status] ?? ['label' => $order->status, 'color' => 'bg-gray-100 text-gray-800'];
                @endphp
                <span class="px-5 py-3 rounded-lg text-base font-semibold {{ $status['color'] }}">
                    {{ $status['label'] }}
                </span>
            </div>

            <!-- Order Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-gray-200">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">@t('Alamat Pengiriman')</h3>
                    <p class="text-[#2F4F4F]">{{ $order->address ?: @t('Belum diisi') }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">@t('Metode Pembayaran')</h3>
                    <p class="text-[#2F4F4F]">{{ $order->payment_method }}</p>
                </div>
            </div>
        </div>

                </div>

        <!-- Review Reminder (if completed) -->
        @if($order->status === 'completed')
            @php
                $unreviewedBooks = $order->items->filter(function($item) {
                    return !$item->book->reviews()->where('user_id', auth()->id())->exists();
                });
            @endphp
            @if($unreviewedBooks->count() > 0)
                <div class="bg-gradient-to-r from-[#4B5320] to-[#2F4F4F] text-white rounded-lg shadow-sm p-6 mb-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold mb-1">@t('Pesanan Selesai! 🎉')</h3>
                            <p class="text-white text-opacity-90 mb-3">
                                @t('Bagikan pengalaman Anda! Ada') {{ $unreviewedBooks->count() }} @t('buku yang belum Anda ulas. Ulasan Anda sangat membantu pembaca lain dalam memilih buku.')
                            </p>
                            <p class="text-sm text-white text-opacity-75">
                                @t('Klik tombol "Beri Ulasan" pada buku di bawah untuk memulai.')
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        <!-- Shipping Notes (if any) -->
        @if($order->shipping_notes)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-5 mb-6">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="flex-1">
                    <h3 class="text-base font-semibold text-blue-900 mb-1">📦 @t('Catatan Pengiriman')</h3>
                    <p class="text-blue-800">{{ $order->shipping_notes }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Order Items -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
            <div class="bg-[#4B5320] text-white px-6 py-4">
                <h2 class="text-lg font-bold">@t('Item Pesanan')</h2>
            </div>
            
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($order->items as $item)
                    <div class="flex items-center gap-4 pb-4 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                        <!-- Book Cover -->
                        <div class="flex-shrink-0 w-20 h-28 bg-gray-100 rounded-lg overflow-hidden shadow-sm">
                            @if($item->book->cover_image)
                                <img src="{{ asset('storage/' . $item->book->cover_image) }}" 
                                     alt="{{ $item->book->title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Book Info -->
                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-[#2F4F4F] mb-1">{{ $item->book->title }}</h4>
                            <p class="text-sm text-gray-600">@t('Penulis'): {{ $item->book->author }}</p>
                            <div class="flex items-center gap-4 mt-2">
                                <p class="text-sm text-gray-600">@t('Harga'): Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                <p class="text-sm text-gray-600">@t('Jumlah'): {{ $item->quantity }}</p>
                            </div>
                            
                            <!-- Review Button (only if order completed) -->
                            @if($order->status === 'completed')
                                @php
                                    $hasReviewed = $item->book->reviews()->where('user_id', auth()->id())->exists();
                                @endphp
                                @if($hasReviewed)
                                    <a href="{{ route('books.show', $item->book->id) }}#reviews" 
                                       class="inline-flex items-center gap-1 mt-3 text-sm text-blue-600 hover:text-blue-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        @t('Lihat Ulasan Anda')
                                    </a>
                                @else
                                    <a href="{{ route('books.show', $item->book->id) }}#reviews" 
                                       class="inline-flex items-center gap-1 mt-3 px-3 py-1.5 bg-[#4B5320] text-white text-sm rounded-lg hover:bg-[#2F4F4F] transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                        </svg>
                                        @t('Beri Ulasan')
                                    </a>
                                @endif
                            @endif
                        </div>
                        
                        <!-- Subtotal -->
                        <div class="text-right">
                            <p class="text-sm text-gray-600 mb-1">@t('Subtotal')</p>
                            <p class="text-xl font-bold text-[#4B5320]">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="bg-[#D2B48C] bg-opacity-20 px-6 py-4">
                <h2 class="text-lg font-bold text-[#2F4F4F]">@t('Ringkasan Pembayaran')</h2>
            </div>
            
            <div class="p-6">
                <div class="space-y-3 mb-4">
                    <div class="flex justify-between text-gray-600">
                        <span>@t('Subtotal') ({{ $order->items->count() }} item)</span>
                        <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>@t('Biaya Pengiriman')</span>
                        <span class="text-green-600 font-medium">@t('Gratis')</span>
                    </div>
                </div>
                
                <div class="pt-4 border-t-2 border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold text-[#2F4F4F]">@t('Total Pembayaran')</span>
                        <span class="text-2xl font-bold text-[#4B5320]">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        @if($order->status == 'completed' && config('features.pdf_invoice'))
        <div class="mt-6 flex justify-end">
            <a href="{{ route('report.invoice', $order->id) }}" 
               target="_blank"
               class="inline-flex items-center px-6 py-3 bg-[#4B5320] text-white rounded-lg hover:bg-opacity-90 transition font-medium shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                </svg>
                @t('Unduh Invoice')
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
