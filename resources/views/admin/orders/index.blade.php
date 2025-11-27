@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F5F5F5] py-8 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8  ">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#2F4F4F] dark:text-gray-100 font-lora mb-2 transition-colors duration-300">@t('Manajemen Pesanan')</h1>
            <p class="text-gray-600 dark:text-gray-400 transition-colors duration-300">@t('Kelola semua pesanan dari pelanggan')</p>
        </div>

        <!-- Search & Filter -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6 transition-colors duration-300">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2 transition-colors duration-300">@t('Cari Pesanan')</label>
                        <input type="text" 
                               name="q" 
                               value="{{ $q ?? '' }}"
                               placeholder="@t('ID Pesanan, Nama User, Email, Judul Buku...')"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-[#4B5320] focus:border-transparent transition-colors duration-300">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2 transition-colors duration-300">@t('Status Pesanan')</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-[#4B5320] focus:border-transparent transition-colors duration-300">
                            <option value="">@t('Semua Status')</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>@t('Menunggu Pembayaran')</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>@t('Diproses')</option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>@t('Dikirim')</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>@t('Selesai')</option>
                        </select>
                    </div>

                    <!-- User Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2 transition-colors duration-300">@t('Filter User')</label>
                        <select name="user" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-[#4B5320] focus:border-transparent transition-colors duration-300">
                            <option value="">@t('Semua User')</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" {{ request('user') == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }} ({{ $u->orders_count }} @t('pesanan'))
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" 
                            class="px-6 py-2 bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 rounded-lg hover:bg-opacity-90 transition font-medium">
                        @t('Terapkan Filter')
                    </button>
                    <a href="{{ route('admin.orders.index') }}" 
                       class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition font-medium">
                        @t('Reset')
                    </a>
                </div>
            </form>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            @php
                $allOrders = \App\Models\Order::all();
                $pendingCount = $allOrders->where('status', 'pending')->count();
                $processingCount = $allOrders->where('status', 'processing')->count();
                $shippedCount = $allOrders->where('status', 'shipped')->count();
                $completedCount = $allOrders->where('status', 'completed')->count();
            @endphp

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 transition-colors duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1 transition-colors duration-300">@t('Menunggu Pembayaran')</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $pendingCount }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center transition-colors duration-300">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 transition-colors duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1 transition-colors duration-300">@t('Diproses')</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $processingCount }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center transition-colors duration-300">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 transition-colors duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1 transition-colors duration-300">@t('Dikirim')</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $shippedCount }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center transition-colors duration-300">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 transition-colors duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1 transition-colors duration-300">@t('Selesai')</p>
                        <p class="text-2xl font-bold text-green-600">{{ $completedCount }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center transition-colors duration-300">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        @if($orders->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden transition-colors duration-300">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-[#4B5320] dark:bg-gray-700 text-white transition-colors duration-300">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold dark:text-gray-400 transition-colors duration-300">@t('ID Pesanan')</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold dark:text-gray-400 transition-colors duration-300">@t('Pelanggan')</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold dark:text-gray-400 transition-colors duration-300">@t('Tanggal')</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold dark:text-gray-400 transition-colors duration-300">@t('Total')</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold dark:text-gray-400 transition-colors duration-300">@t('Status')</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold dark:text-gray-400 transition-colors duration-300">@t('Aksi')</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 transition-colors duration-300">
                            @foreach($orders as $order)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <td class="px-6 py-4">
                                    <span class="font-bold text-[#2F4F4F] dark:text-gray-100 transition-colors duration-300">#{{ $order->id }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-medium text-[#2F4F4F] dark:text-gray-100 transition-colors duration-300">{{ $order->user->name }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 transition-colors duration-300">{{ $order->user->email }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400 transition-colors duration-300">
                                    {{ $order->created_at->format('d M Y') }}
                                    <br>
                                    <span class="text-xs">{{ $order->created_at->format('H:i') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-[#4B5320] dark:text-[#9acd32] transition-colors duration-300">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusConfig = [
                                            'pending' => ['label' => '@t("Menunggu Pembayaran")', 'color' => 'bg-yellow-100 text-yellow-800'],
                                            'processing' => ['label' => '@t("Diproses")', 'color' => 'bg-blue-100 text-blue-800'],
                                            'shipped' => ['label' => '@t("Dikirim")', 'color' => 'bg-purple-100 text-purple-800'],
                                            'completed' => ['label' => '@t("Selesai")', 'color' => 'bg-green-100 text-green-800']
                                        ];
                                        $status = $statusConfig[$order->status] ?? ['label' => $order->status, 'color' => 'bg-gray-100 text-gray-800'];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $status['color'] }}">
                                        {!! $status['label'] !!}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 rounded-lg hover:bg-opacity-90 transition text-sm font-medium">
                                        @t('Detail')
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 transition-colors duration-300">
                    {{ $orders->links() }}
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-12 text-center transition-colors duration-300">
                <svg class="w-24 h-24 mx-auto text-gray-300 dark:text-gray-600 mb-4 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <h3 class="text-xl font-bold text-[#2F4F4F] dark:text-gray-100 mb-2 transition-colors duration-300">@t('Tidak Ada Pesanan')</h3>
                <p class="text-gray-600 dark:text-gray-400 transition-colors duration-300">@t('Belum ada pesanan yang sesuai dengan filter yang dipilih')</p>
            </div>
        @endif
    </div>
</div>
@endsection
