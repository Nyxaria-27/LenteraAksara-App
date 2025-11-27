@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F5F5F5] py-8 dark:bg-gray-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.orders.index') }}" 
               class="inline-flex items-center text-[#4B5320] dark:text-[#9acd32] hover:text-[#2F4F4F] dark:hover:text-[#7ab32e] transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                @t('Kembali ke Daftar Pesanan')
            </a>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Order Details (Left Column) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Header -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 transition-colors duration-300">
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-[#2F4F4F] dark:text-gray-100 font-lora mb-1 transition-colors duration-300">@t('Pesanan') #{{ $order->id }}</h1>
                            <p class="text-gray-600 dark:text-gray-400 transition-colors duration-300">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        
                        <!-- Status Badge -->
                        @php
                            $statusConfig = [
                                'pending' => ['label' => '@t("Menunggu Pembayaran")', 'color' => 'bg-yellow-100 text-yellow-800'],
                                'processing' => ['label' => '@t("Diproses")', 'color' => 'bg-blue-100 text-blue-800'],
                                'shipped' => ['label' => '@t("Dikirim")', 'color' => 'bg-purple-100 text-purple-800'],
                                'completed' => ['label' => '@t("Selesai")', 'color' => 'bg-green-100 text-green-800']
                            ];
                            $status = $statusConfig[$order->status] ?? ['label' => $order->status, 'color' => 'bg-gray-100 text-gray-800'];
                        @endphp
                        <span class="px-5 py-3 rounded-lg text-base font-semibold {{ $status['color'] }}">
                            {!! $status['label'] !!}
                        </span>
                    </div>

                    <!-- Customer Info -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6 transition-colors duration-300">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-3 transition-colors duration-300">@t('Informasi Pelanggan')</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 transition-colors duration-300">@t('Nama')</p>
                                <p class="text-[#2F4F4F] dark:text-gray-100 font-medium transition-colors duration-300">{{ $order->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 transition-colors duration-300">@t('Email')</p>
                                <p class="text-[#2F4F4F] dark:text-gray-100 font-medium transition-colors duration-300">{{ $order->user->email }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400 transition-colors duration-300">@t('Alamat Pengiriman')</p>
                                <p class="text-[#2F4F4F] dark:text-gray-100 font-medium transition-colors duration-300">{{ $order->address ?: '@t("Belum diisi")' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 transition-colors duration-300">@t('Metode Pembayaran')</p>
                                <p class="text-[#2F4F4F] dark:text-gray-100 font-medium transition-colors duration-300">{{ $order->payment_method }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden transition-colors duration-300">
                    <div class="bg-[#4B5320] text-white px-6 py-4">
                        <h2 class="text-lg font-bold">@t('Item Pesanan') ({{ $order->items->count() }} @t('item'))</h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                            <div class="flex items-center gap-4 pb-4 {{ !$loop->last ? 'border-b border-gray-200 dark:border-gray-700' : '' }} transition-colors duration-300">
                                <!-- Book Cover -->
                                <div class="flex-shrink-0 w-16 h-24 bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden shadow-sm transition-colors duration-300">
                                    @if($item->book->cover_image)
                                        <img src="{{ asset('storage/' . $item->book->cover_image) }}" 
                                             alt="{{ $item->book->title }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-500 transition-colors duration-300">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Book Info -->
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-[#2F4F4F] dark:text-gray-100 mb-1 transition-colors duration-300">{{ $item->book->title }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 transition-colors duration-300">{{ $item->book->author }}</p>
                                    <div class="flex items-center gap-4 mt-2">
                                        <p class="text-sm text-gray-600 dark:text-gray-400 transition-colors duration-300">Rp {{ number_format($item->price, 0, ',', '.') }} x {{ $item->quantity }}</p>
                                    </div>
                                </div>
                                
                                <!-- Subtotal -->
                                <div class="text-right">
                                    <p class="text-lg font-bold text-[#4B5320] dark:text-[#9acd32] transition-colors duration-300">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Order Summary -->
                        <div class="mt-6 pt-6 border-t-2 border-gray-200 dark:border-gray-700 transition-colors duration-300">
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-[#2F4F4F] dark:text-gray-100 transition-colors duration-300">@t('Total Pembayaran')</span>
                                <span class="text-2xl font-bold text-[#4B5320] dark:text-[#9acd32] transition-colors duration-300">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Current Shipping Notes (if any) -->
                @if($order->shipping_notes)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-5">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <h3 class="text-base font-semibold text-blue-900 mb-1">📦 @t('Catatan Pengiriman Saat Ini')</h3>
                            <p class="text-blue-800">{{ $order->shipping_notes }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Status Management (Right Column) -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 sticky top-8 transition-colors duration-300">
                    <h2 class="text-lg font-bold text-[#2F4F4F] dark:text-gray-100 mb-6 transition-colors duration-300">@t('Ubah Status Pesanan')</h2>

                    @if($order->status === 'completed')
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                            <svg class="w-12 h-12 mx-auto text-green-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="font-semibold text-green-900 mb-1">@t('Pesanan Selesai')</p>
                            <p class="text-sm text-green-700">@t('Status pesanan tidak dapat diubah lagi')</p>
                        </div>
                    @else
                        <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Status Selection -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-3 transition-colors duration-300">@t('Status Baru')</label>
                                <div class="space-y-3">
                                    <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition {{ $order->status == 'pending' ? 'border-yellow-400 bg-yellow-50 dark:bg-yellow-900/20' : 'border-gray-200 dark:border-gray-600 hover:border-yellow-300 dark:hover:border-yellow-500' }}">
                                        <input type="radio" name="status" value="pending" 
                                               class="w-4 h-4 text-yellow-600 focus:ring-yellow-500" 
                                               {{ $order->status == 'pending' ? 'checked' : '' }}>
                                        <span class="ml-3 font-medium text-gray-900 dark:text-gray-100 transition-colors duration-300">@t('Menunggu Pembayaran')</span>
                                    </label>

                                    <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition {{ $order->status == 'processing' ? 'border-blue-400 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-200 dark:border-gray-600 hover:border-blue-300 dark:hover:border-blue-500' }}">
                                        <input type="radio" name="status" value="processing" 
                                               class="w-4 h-4 text-blue-600 focus:ring-blue-500"
                                               {{ $order->status == 'processing' ? 'checked' : '' }}>
                                        <span class="ml-3 font-medium text-gray-900 dark:text-gray-100 transition-colors duration-300">@t('Diproses')</span>
                                    </label>

                                    <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition {{ $order->status == 'shipped' ? 'border-purple-400 bg-purple-50 dark:bg-purple-900/20' : 'border-gray-200 dark:border-gray-600 hover:border-purple-300 dark:hover:border-purple-500' }}">
                                        <input type="radio" name="status" value="shipped" 
                                               class="w-4 h-4 text-purple-600 focus:ring-purple-500"
                                               {{ $order->status == 'shipped' ? 'checked' : '' }}>
                                        <span class="ml-3 font-medium text-gray-900 dark:text-gray-100 transition-colors duration-300">@t('Dikirim')</span>
                                    </label>

                                    <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition {{ $order->status == 'completed' ? 'border-green-400 bg-green-50 dark:bg-green-900/20' : 'border-gray-200 dark:border-gray-600 hover:border-green-300 dark:hover:border-green-500' }}">
                                        <input type="radio" name="status" value="completed" 
                                               class="w-4 h-4 text-green-600 focus:ring-green-500"
                                               {{ $order->status == 'completed' ? 'checked' : '' }}>
                                        <span class="ml-3 font-medium text-gray-900 dark:text-gray-100 transition-colors duration-300">@t('Selesai')</span>
                                    </label>
                                </div>
                                @error('status')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Shipping Notes -->
                            <div>
                                <label for="shipping_notes" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2 transition-colors duration-300">
                                    @t('Catatan Pengiriman')
                                    <span class="text-gray-500 dark:text-gray-400 font-normal transition-colors duration-300">(@t('Opsional'))</span>
                                </label>
                                <textarea id="shipping_notes" 
                                          name="shipping_notes" 
                                          rows="4"
                                          placeholder="@t('Contoh: Paket dikirim via JNE dengan nomor resi 1234567890')"
                                          class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-[#4B5320] focus:border-transparent resize-none transition-colors duration-300">{{ old('shipping_notes', $order->shipping_notes) }}</textarea>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 transition-colors duration-300">@t('Catatan ini akan dilihat oleh pelanggan')</p>
                                @error('shipping_notes')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" 
                                    class="w-full px-6 py-3 bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 rounded-lg hover:bg-opacity-90 transition font-semibold shadow-sm">
                                @t('Perbarui Status Pesanan')
                            </button>
                        </form>
                    @endif

                    <!-- Action Buttons -->
                    @if(config('features.pdf_invoice'))
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 transition-colors duration-300">
                        <a href="{{ route('report.invoice', $order->id) }}" 
                           target="_blank"
                           class="block w-full px-6 py-3 bg-[#D2B48C] dark:bg-[#9acd32] text-[#2F4F4F] dark:text-gray-900 text-center rounded-lg hover:bg-opacity-80 transition font-semibold shadow-sm">
                            📄 @t('Lihat Invoice')
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
