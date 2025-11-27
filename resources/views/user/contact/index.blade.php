@extends('layouts.app')

@section('title', '@t("Hubungi Kami") - Lentera Aksara')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-[#F5F5F5] to-white dark:from-gray-900 dark:to-gray-800 py-12 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-[#2F4F4F] dark:text-gray-100 mb-4 font-serif">@t('Hubungi Kami')</h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">@t('Kami siap membantu Anda. Pilih cara yang paling nyaman untuk Anda.')</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 dark:border-green-400 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 dark:text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-green-700 dark:text-green-300 font-medium">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 dark:border-red-400 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 dark:text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="text-red-700 dark:text-red-300 font-medium">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Left: Contact Options -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-gray-700 transition-colors duration-300">
                    <h3 class="text-xl font-bold text-[#2F4F4F] dark:text-gray-100 mb-4 font-serif">@t('Cara Lain Menghubungi')</h3>
                    
                    <!-- WhatsApp -->
                    <a href="https://wa.me/6281234567890?text=Halo%20Lentera%20Aksara%2C%20saya%20ingin%20bertanya%20tentang..." 
                       target="_blank"
                       class="flex items-center gap-4 p-4 bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 hover:from-green-100 hover:to-green-200 dark:hover:from-green-800/40 dark:hover:to-green-700/40 rounded-lg mb-4 transition-all group">
                        <div class="flex-shrink-0 w-12 h-12 bg-green-500 dark:bg-green-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-[#2F4F4F] dark:text-gray-100 mb-1">WhatsApp</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">@t('Chat langsung dengan admin')</p>
                            <p class="text-xs text-green-600 dark:text-green-400 font-medium mt-1">+62 812-3456-7890</p>
                        </div>
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                    <!-- Email -->
                    <a href="mailto:admin@lenteraaksara.com?subject=Pertanyaan dari Website&body=Halo Lentera Aksara,%0D%0A%0D%0A" 
                       class="flex items-center gap-4 p-4 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800/40 dark:hover:to-blue-700/40 rounded-lg mb-4 transition-all group">
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-500 dark:bg-blue-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-[#2F4F4F] dark:text-gray-100 mb-1">Email</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">@t('Kirim email ke kami')</p>
                            <p class="text-xs text-blue-600 dark:text-blue-400 font-medium mt-1">admin@lenteraaksara.com</p>
                        </div>
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                    <!-- Info -->
                    <div class="mt-6 p-4 bg-[#F5F5F5] dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 transition-colors duration-300">
                        <h4 class="font-semibold text-[#2F4F4F] dark:text-gray-100 mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#4B5320] dark:text-[#9acd32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            @t('Jam Operasional')
                        </h4>
                        <p class="text-sm text-gray-600 dark:text-gray-300">@t('Senin - Jumat: 08:00 - 17:00')</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">@t('Sabtu: 08:00 - 14:00')</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">@t('Minggu & Libur: Tutup')</p>
                    </div>
                </div>
            </div>

            <!-- Right: Contact Form & Conversation -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-[#2F4F4F] to-[#4B5320] dark:from-gray-700 dark:to-gray-600 px-6 py-4">
                        <h3 class="text-xl font-bold text-white flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                            @t('Pesan Dukungan')
                        </h3>
                        <p class="text-sm text-gray-200 dark:text-gray-300 mt-1">@t('Kirim pesan melalui form dan admin akan membalas di sini')</p>
                    </div>

                    <!-- Conversation Area -->
                    @if($contact)
                    <div class="p-6 max-h-[500px] overflow-y-auto bg-gray-50 dark:bg-gray-900/50" id="conversationArea">
                        <!-- Status Badge -->
                        <div class="mb-6 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">@t('Status'):</span>
                                @if($contact->status === 'open')
                                    <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/40 text-yellow-700 dark:text-yellow-300 text-xs font-semibold rounded-full">@t('Menunggu Balasan')</span>
                                @elseif($contact->status === 'replied')
                                    <span class="px-3 py-1 bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300 text-xs font-semibold rounded-full">@t('Sudah Dibalas')</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs font-semibold rounded-full">{{ ucfirst($contact->status) }}</span>
                                @endif
                            </div>
                            @if($contact->updated_at)
                            <span class="text-xs text-gray-500 dark:text-gray-400">@t('Terakhir update'): {{ $contact->updated_at->diffForHumans() }}</span>
                            @endif
                        </div>

                        <!-- User Messages -->
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-end">
                                <div class="max-w-[80%]">
                                    @if($contact->subject)
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-1 text-right">@t('Subjek'): {{ $contact->subject }}</div>
                                    @endif
                                    <div class="bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 rounded-lg rounded-tr-none px-4 py-3 shadow-sm">
                                        <pre class="whitespace-pre-wrap font-sans text-sm leading-relaxed">{{ $contact->message }}</pre>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 text-right">{{ $contact->created_at->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Admin Reply -->
                        @if($contact->admin_reply)
                        <div class="space-y-4">
                            <div class="flex justify-start">
                                <div class="max-w-[80%]">
                                    <div class="flex items-center gap-2 mb-1">
                                        <div class="w-8 h-8 bg-[#2F4F4F] dark:bg-gray-600 rounded-full flex items-center justify-center text-white text-sm font-semibold">A</div>
                                        <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Admin</span>
                                    </div>
                                    <div class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg rounded-tl-none px-4 py-3 shadow-sm">
                                        <pre class="whitespace-pre-wrap font-sans text-sm leading-relaxed text-gray-700 dark:text-gray-200">{{ $contact->admin_reply }}</pre>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $contact->updated_at->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="p-8 text-center bg-gray-50 dark:bg-gray-900/50">
                        <div class="w-20 h-20 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 font-medium">@t('Belum ada percakapan')</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">@t('Kirim pesan pertama Anda di bawah ini')</p>
                    </div>
                    @endif

                    <!-- Message Form -->
                    <div class="border-t border-gray-200 dark:border-gray-700 p-6 bg-white dark:bg-gray-800 transition-colors duration-300">
                        <form action="{{ route('user.contact.store') }}" method="POST">
                            @csrf
                            
                            @if(!$contact)
                            <div class="mb-4">
                                <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">@t('Subjek') <span class="text-gray-400">(@t('Opsional'))</span></label>
                                <input type="text" 
                                       id="subject" 
                                       name="subject" 
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-[#4B5320] dark:focus:ring-[#9acd32] focus:border-transparent transition-all"
                                       placeholder="@t('Misal: Pertanyaan tentang pengiriman')"
                                       value="{{ old('subject') }}">
                                @error('subject')
                                <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif

                            <div class="mb-4">
                                <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    @if($contact)
                                        @t('Kirim Pesan Lanjutan')
                                    @else
                                        @t('Pesan Anda')
                                    @endif
                                </label>
                                <textarea id="message" 
                                          name="message" 
                                          rows="5" 
                                          class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-[#4B5320] dark:focus:ring-[#9acd32] focus:border-transparent transition-all resize-none"
                                          placeholder="@t('Tulis pesan Anda di sini...')"
                                          required>{{ old('message') }}</textarea>
                                @error('message')
                                <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between">
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    @t('Balasan akan muncul di halaman ini')
                                </p>
                                <button type="submit" 
                                        class="px-6 py-2.5 bg-gradient-to-r from-[#2F4F4F] to-[#4B5320] dark:from-[#9acd32] dark:to-[#7ab32e] text-white dark:text-gray-900 font-medium rounded-lg hover:shadow-lg transition-all flex items-center gap-2 group">
                                    <span>@t('Kirim Pesan')</span>
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-scroll to bottom of conversation
document.addEventListener('DOMContentLoaded', function() {
    const conversationArea = document.getElementById('conversationArea');
    if (conversationArea) {
        conversationArea.scrollTop = conversationArea.scrollHeight;
    }
});
</script>
@endsection
