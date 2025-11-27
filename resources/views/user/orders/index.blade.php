@extends('layouts.app')

@php
    use App\Helpers\TranslatorHelper;
@endphp

@section('content')
<div class="min-h-screen bg-[#F5F5F5] dark:bg-gray-900 py-8 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#2F4F4F] dark:text-gray-100 font-lora mb-2">@t('Pesanan Saya')</h1>
            <p class="text-gray-600 dark:text-gray-400">@t('Lihat dan lacak pesanan Anda')</p>
        </div>

        <!-- Status Filter Tabs -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 mb-6 transition-colors duration-300">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('user.orders.index') }}" 
                   class="px-4 py-2 rounded-lg font-medium transition {{ !request('status') ? 'bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                    @t('Semua Pesanan')
                </a>
                <a href="{{ route('user.orders.index', ['status' => 'pending']) }}" 
                   class="px-4 py-2 rounded-lg font-medium transition {{ request('status') == 'pending' ? 'bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                    @t('Menunggu Pembayaran')
                </a>
                <a href="{{ route('user.orders.index', ['status' => 'processing']) }}" 
                   class="px-4 py-2 rounded-lg font-medium transition {{ request('status') == 'processing' ? 'bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                    @t('Diproses')
                </a>
                <a href="{{ route('user.orders.index', ['status' => 'shipped']) }}" 
                   class="px-4 py-2 rounded-lg font-medium transition {{ request('status') == 'shipped' ? 'bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                    @t('Dikirim')
                </a>
                <a href="{{ route('user.orders.index', ['status' => 'completed']) }}" 
                   class="px-4 py-2 rounded-lg font-medium transition {{ request('status') == 'completed' ? 'bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                    @t('Selesai')
                </a>
            </div>
        </div>

        <!-- Orders List -->
        @if($orders->count() > 0)
            <div class="space-y-4">
                @foreach($orders as $order)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                    <!-- Order Header -->
                    <div class="bg-[#D2B48C] bg-opacity-10 dark:bg-gray-700/50 px-6 py-4 border-b border-gray-200 dark:border-gray-600 transition-colors duration-300">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">@t('Nomor Pesanan')</p>
                                    <p class="font-bold text-[#2F4F4F] dark:text-gray-100">#{{ $order->id }}</p>
                                </div>
                                <div class="hidden sm:block w-px h-12 bg-gray-300 dark:bg-gray-600"></div>
                                <div class="hidden sm:block">
                                    <p class="text-sm text-gray-600 dark:text-gray-400">@t('Tanggal Pesanan')</p>
                                    <p class="font-medium text-[#2F4F4F] dark:text-gray-100">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            
                            <!-- Status Badge -->
                            <div>
                                @php
                                    $statusConfig = [
                                        'pending' => ['label' => TranslatorHelper::translate('Menunggu Pembayaran'), 'color' => 'bg-yellow-100 text-yellow-800'],
                                        'processing' => ['label' => TranslatorHelper::translate('Diproses'), 'color' => 'bg-blue-100 text-blue-800'],
                                        'shipped' => ['label' => TranslatorHelper::translate('Dikirim'), 'color' => 'bg-purple-100 text-purple-800'],
                                        'completed' => ['label' => TranslatorHelper::translate('Selesai'), 'color' => 'bg-green-100 text-green-800']
                                    ];
                                    $status = $statusConfig[$order->status] ?? ['label' => $order->status, 'color' => 'bg-gray-100 text-gray-800'];
                                @endphp
                                <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $status['color'] }}">
                                    {{ $status['label'] }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="px-6 py-4">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-4 py-3 {{ !$loop->last ? 'border-b border-gray-100 dark:border-gray-700' : '' }}">
                            <div class="flex-shrink-0 w-16 h-20 bg-gray-100 dark:bg-gray-700 rounded overflow-hidden">
                                @if($item->book->cover_image)
                                    <img src="{{ asset('storage/' . $item->book->cover_image) }}" 
                                         alt="{{ $item->book->title }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-[#2F4F4F] dark:text-gray-100 truncate">{{ $item->book->title }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-[#4B5320] dark:text-[#9acd32]">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Order Footer -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex flex-wrap items-center justify-between gap-4 transition-colors duration-300">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">@t('Total Pembayaran')</p>
                            <p class="text-2xl font-bold text-[#2F4F4F] dark:text-gray-100">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>
                        
                        <div class="flex gap-2">
                            <a href="{{ route('user.orders.show', $order->id) }}" 
                               class="px-5 py-2 bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 rounded-lg hover:bg-opacity-90 transition font-medium">
                                @t('Lihat Detail')
                            </a>
                            
                            @if($order->status == 'completed' && config('features.pdf_invoice'))
                            <a href="{{ route('report.invoice', $order->id) }}" 
                               target="_blank"
                               class="px-5 py-2 bg-[#D2B48C] dark:bg-[#8b7355] text-[#2F4F4F] dark:text-gray-100 rounded-lg hover:bg-opacity-80 transition font-medium">
                                @t('Unduh Invoice')
                            </a>
                            @endif
                        </div>
                    </div>

                    <!-- Shipping Notes (if available) -->
                    @if($order->shipping_notes)
                    <div class="bg-blue-50 dark:bg-blue-900/30 border-t border-blue-100 dark:border-blue-800 px-6 py-3 transition-colors duration-300">
                        <p class="text-sm font-semibold text-blue-900 dark:text-blue-300 mb-1">📦 @t('Catatan Pengiriman')</p>
                        <p class="text-sm text-blue-800 dark:text-blue-200">{{ $order->shipping_notes }}</p>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-12 text-center transition-colors duration-300">
                <svg class="w-24 h-24 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <h3 class="text-xl font-bold text-[#2F4F4F] dark:text-gray-100 mb-2">@t('Belum Ada Pesanan')</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    @if(request('status'))
                        @t('Anda belum memiliki pesanan dengan status') "{{ $statusConfig[request('status')]['label'] ?? request('status') }}"
                    @else
                        @t('Anda belum pernah melakukan pemesanan')
                    @endif
                </p>
                <a href="{{ route('user.dashboard') }}" 
                   class="inline-block px-6 py-3 bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 rounded-lg hover:bg-opacity-90 transition font-medium">
                    @t('Mulai Belanja')
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
