@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F5F5F5] py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#2F4F4F] font-lora mb-2">@t('Checkout')</h1>
            <p class="text-gray-600">@t('Lengkapi informasi pengiriman dan pembayaran Anda')</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-red-800 mb-2">@t('Terdapat kesalahan'):</h3>
                        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('checkout.store') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            @csrf
            
            <!-- Checkout Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Shipping Address -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-[#2F4F4F] mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-[#4B5320]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        @t('Alamat Pengiriman')
                    </h2>
                    
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                            @t('Alamat Lengkap') <span class="text-red-500">*</span>
                        </label>
                        <textarea id="address" 
                                  name="address" 
                                  rows="5" 
                                  required
                                  placeholder="@t('Contoh: Jl. Merdeka No. 123, RT 01/RW 05, Kelurahan Menteng, Kecamatan Menteng, Jakarta Pusat, DKI Jakarta 10310')"
                                  class="w-full px-4 py-3 border @error('address') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-[#4B5320] focus:border-transparent">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500">
                            💡 <strong>Minimal 20 karakter.</strong> Pastikan alamat lengkap: Jalan, Nomor, RT/RW, Kelurahan, Kecamatan, Kota, Provinsi, Kode Pos
```
                        </p>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-[#2F4F4F] mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-[#4B5320]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        @t('Metode Pembayaran')
                    </h2>
                    
                    <div class="space-y-3">
                        <label class="flex items-start p-4 border-2 border-[#4B5320] bg-[#4B5320] bg-opacity-5 rounded-lg cursor-pointer">
                            <input type="radio" 
                                   name="payment_method" 
                                   value="COD" 
                                   checked
                                   class="mt-1 w-4 h-4 text-[#4B5320] focus:ring-[#4B5320]">
                            <div class="ml-3">
                                <span class="font-medium text-[#2F4F4F]">@t('Cash on Delivery (COD)')</span>
                                <p class="text-sm text-gray-600 mt-1">@t('Bayar langsung saat barang diterima')</p>
                            </div>
                        </label>

                        <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer opacity-50">
                            <input type="radio" 
                                   name="payment_method" 
                                   value="Transfer Bank" 
                                   disabled
                                   class="mt-1 w-4 h-4 text-gray-400">
                            <div class="ml-3">
                                <span class="font-medium text-gray-500">@t('Transfer Bank')</span>
                                <p class="text-sm text-gray-500 mt-1">@t('Segera hadir')</p>
                            </div>
                        </label>

                        <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer opacity-50">
                            <input type="radio" 
                                   name="payment_method" 
                                   value="E-Wallet" 
                                   disabled
                                   class="mt-1 w-4 h-4 text-gray-400">
                            <div class="ml-3">
                                <span class="font-medium text-gray-500">@t('E-Wallet (GoPay, OVO, DANA)')</span>
                                <p class="text-sm text-gray-500 mt-1">@t('Segera hadir')</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-4">
                    <h2 class="text-xl font-bold text-[#2F4F4F] mb-6">@t('Ringkasan Pesanan')</h2>
                    
                    <!-- Cart Items -->
                    <div class="space-y-3 mb-6 max-h-60 overflow-y-auto">
                        @foreach($cart->items as $item)
                        <div class="flex items-center gap-3 pb-3 border-b border-gray-100">
                            <div class="w-12 h-16 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                                @if($item->book->cover_image)
                                    <img src="{{ asset('storage/' . $item->book->cover_image) }}" 
                                         alt="{{ $item->book->title }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-medium text-[#2F4F4F] truncate">{{ $item->book->title }}</h4>
                                <p class="text-xs text-gray-600">{{ $item->quantity }} x Rp {{ number_format($item->book->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Price Summary -->
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>@t('Subtotal') ({{ $cart->items->count() }} @t('item'))</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>@t('Biaya Pengiriman')</span>
                            <span class="text-green-600 font-medium">@t('Gratis')</span>
                        </div>
                        <div class="pt-3 border-t-2 border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-[#2F4F4F]">@t('Total')</span>
                                <span class="text-2xl font-bold text-[#4B5320]">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full px-6 py-3 bg-[#4B5320] text-white rounded-lg hover:bg-[#2F4F4F] transition-colors font-semibold shadow-sm">
                        @t('Buat Pesanan')
                    </button>

                    <a href="{{ route('cart.index') }}" 
                       class="block w-full mt-3 px-6 py-3 bg-gray-100 text-[#2F4F4F] rounded-lg hover:bg-gray-200 transition-colors font-medium text-center">
                        @t('Kembali ke Keranjang')
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
