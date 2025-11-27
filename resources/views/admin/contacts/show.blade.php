@extends('layouts.app')

@section('title', 'Detail Pesan Kontak - Lentera Aksara')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with Back Button -->
        <div class="mb-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.contacts.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors gap-2 dark:text-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    @t('Kembali')
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-[#2F4F4F] dark:text-gray-100 font-serif transition-colors duration-300">@t('Detail Pesan')</h1>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1 transition-colors duration-300">ID: #{{ $contact->id }}</p>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-green-700 font-medium">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-6">
            <!-- User Info Card -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                    <div class="bg-gradient-to-r from-[#2F4F4F] to-[#4B5320] px-6 py-4">
                        <h3 class="text-lg font-bold text-white">@t('Informasi Pengguna')</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-col items-center text-center mb-6">
                            <div class="w-20 h-20 rounded-full bg-[#4B5320] dark:bg-[#9acd32] flex items-center justify-center text-white dark:text-gray-900 text-2xl font-bold mb-3 transition-colors duration-300">
                                {{ strtoupper(substr($contact->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 transition-colors duration-300">{{ $contact->user->name ?? 'Unknown User' }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 transition-colors duration-300">{{ $contact->user->email ?? '-' }}</p>
                        </div>

                        <div class="space-y-4 border-t dark:border-gray-700 pt-4 transition-colors duration-300">
                            <div>
                                <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase transition-colors duration-300">@t('Status')</label>
                                <div class="mt-1">
                                    @if($contact->status === 'open')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            @t('Menunggu Balasan')
                                        </span>
                                    @elseif($contact->status === 'replied')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            @t('Sudah Dibalas')
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ ucfirst($contact->status) }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase transition-colors duration-300">@t('Dibuat')</label>
                                <p class="text-sm text-gray-900 dark:text-gray-100 mt-1 transition-colors duration-300">{{ $contact->created_at->format('d M Y, H:i') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 transition-colors duration-300">{{ $contact->created_at->diffForHumans() }}</p>
                            </div>

                            <div>
                                <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase transition-colors duration-300">@t('Terakhir Update')</label>
                                <p class="text-sm text-gray-900 dark:text-gray-100 mt-1 transition-colors duration-300">{{ $contact->updated_at->format('d M Y, H:i') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 transition-colors duration-300">{{ $contact->updated_at->diffForHumans() }}</p>
                            </div>

                            <div>
                                <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase transition-colors duration-300">@t('Admin Sudah Lihat')</label>
                                <p class="text-sm mt-1">
                                    @if($contact->admin_seen)
                                        <span class="text-green-600 flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            @t('Ya')
                                        </span>
                                    @else
                                        <span class="text-gray-600 dark:text-gray-400 transition-colors duration-300">@t('Belum')</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Conversation Card -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                    <div class="bg-gradient-to-r from-[#2F4F4F] to-[#4B5320] px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            @t('Percakapan')
                        </h3>
                    </div>

                    <!-- Messages -->
                    <div class="p-6 space-y-6 max-h-[600px] overflow-y-auto bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
                        <!-- User Message -->
                        <div class="flex justify-end">
                            <div class="max-w-[80%]">
                                @if($contact->subject)
                                <div class="text-xs text-gray-500 dark:text-gray-400 mb-2 text-right font-medium transition-colors duration-300">
                                    @t('Subjek'): {{ $contact->subject }}
                                </div>
                                @endif
                                <div class="bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 rounded-lg rounded-tr-none px-4 py-3 shadow-sm transition-colors duration-300">
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-6 h-6 rounded-full bg-white bg-opacity-20 dark:bg-gray-900 dark:bg-opacity-20 flex items-center justify-center text-xs font-semibold transition-colors duration-300">
                                            {{ strtoupper(substr($contact->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <span class="text-xs font-medium opacity-90">{{ $contact->user->name ?? 'User' }}</span>
                                    </div>
                                    <pre class="whitespace-pre-wrap font-sans text-sm leading-relaxed">{{ $contact->message }}</pre>
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 text-right transition-colors duration-300">
                                    {{ $contact->created_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                        </div>

                        <!-- Admin Reply -->
                        @if($contact->admin_reply)
                        <div class="flex justify-start">
                            <div class="max-w-[80%]">
                                <div class="bg-white dark:bg-gray-800 border-2 border-[#2F4F4F] dark:border-[#9acd32] rounded-lg rounded-tl-none px-4 py-3 shadow-sm transition-colors duration-300">
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-6 h-6 rounded-full bg-[#2F4F4F] dark:bg-[#9acd32] flex items-center justify-center text-white dark:text-gray-900 text-xs font-semibold transition-colors duration-300">
                                            A
                                        </div>
                                        <span class="text-xs font-medium text-gray-700 dark:text-gray-300 transition-colors duration-300">@t('Admin (Anda)')</span>
                                    </div>
                                    <pre class="whitespace-pre-wrap font-sans text-sm leading-relaxed text-gray-700 dark:text-gray-200 transition-colors duration-300">{{ $contact->admin_reply }}</pre>
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 transition-colors duration-300">
                                    {{ $contact->updated_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Reply Form -->
                    <div class="border-t border-gray-200 dark:border-gray-700 p-6 bg-white dark:bg-gray-800 transition-colors duration-300">
                        <form action="{{ route('admin.contacts.reply', $contact->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="admin_reply" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2 flex items-center gap-2 transition-colors duration-300">
                                    <svg class="w-4 h-4 text-[#4B5320] dark:text-[#9acd32] transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                    </svg>
                                    @t('Balas Pesan')
                                </label>
                                <textarea id="admin_reply" 
                                          name="admin_reply" 
                                          rows="5" 
                                          class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-[#4B5320] focus:border-transparent transition-all resize-none"
                                          placeholder="@t('Tulis balasan untuk pengguna...')"
                                          required>{{ old('admin_reply') }}</textarea>
                                @error('admin_reply')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between">
                                <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 transition-colors duration-300">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    @t('User akan mendapat notifikasi')
                                </p>
                                <button type="submit" 
                                        class="px-6 py-2.5 bg-gradient-to-r from-[#2F4F4F] to-[#4B5320] dark:from-[#9acd32] dark:to-[#7ab32e] text-white dark:text-gray-900 font-medium rounded-lg hover:shadow-lg transition-all flex items-center gap-2 group">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                    <span>@t('Kirim Balasan')</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
