@extends('layouts.app')

@section('title', 'Manajemen Pesan Kontak - Lentera Aksara')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#2F4F4F] dark:text-gray-100 font-serif transition-colors duration-300">@t('Manajemen Pesan Kontak')</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2 transition-colors duration-300">@t('Kelola pesan masuk dari pengguna')</p>
        </div>

        <!-- Search & Filter Bar -->
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6 transition-colors duration-300">
            <form method="GET" action="{{ route('admin.contacts.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2 transition-colors duration-300">@t('Cari Pesan')</label>
                        <div class="relative">
                            <input type="text" 
                                   id="search"
                                   name="q" 
                                   value="{{ $q ?? '' }}"
                                   placeholder="@t('Cari nama, email, subjek, atau isi pesan...')"
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-[#4B5320] focus:border-transparent transition-colors duration-300">
                            <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400 dark:text-gray-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Filter Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2 transition-colors duration-300">@t('Status')</label>
                        <select id="status" 
                                name="status" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-[#4B5320] focus:border-transparent transition-colors duration-300">
                            <option value="">@t('Semua Status')</option>
                            <option value="open" {{ ($status ?? '') === 'open' ? 'selected' : '' }}>@t('Menunggu')</option>
                            <option value="replied" {{ ($status ?? '') === 'replied' ? 'selected' : '' }}>@t('Dibalas')</option>
                            <option value="closed" {{ ($status ?? '') === 'closed' ? 'selected' : '' }}>@t('Ditutup')</option>
                        </select>
                    </div>

                    <!-- Filter Seen -->
                    <div>
                        <label for="seen" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2 transition-colors duration-300">@t('Dibaca')</label>
                        <select id="seen" 
                                name="seen" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-[#4B5320] focus:border-transparent transition-colors duration-300">
                            <option value="">@t('Semua')</option>
                            <option value="unread" {{ ($seen ?? '') === 'unread' ? 'selected' : '' }}>@t('Belum Dibaca')</option>
                            <option value="read" {{ ($seen ?? '') === 'read' ? 'selected' : '' }}>@t('Sudah Dibaca')</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" 
                            class="px-6 py-2 bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 rounded-lg hover:bg-[#3a4019] dark:hover:bg-[#7ab32e] transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        @t('Cari')
                    </button>
                    @if($q || $status || $seen)
                    <a href="{{ route('admin.contacts.index') }}" 
                       class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        @t('Reset Filter')
                    </a>
                    @endif
                </div>
            </form>
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

        <!-- Contacts List -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700 transition-colors duration-300">
            @if($contacts->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-[#2F4F4F] dark:bg-gray-700 transition-colors duration-300">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white dark:text-gray-400 uppercase tracking-wider transition-colors duration-300">@t('Pengguna')</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white dark:text-gray-400 uppercase tracking-wider transition-colors duration-300">@t('Subjek')</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white dark:text-gray-400 uppercase tracking-wider transition-colors duration-300">@t('Pesan')</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white dark:text-gray-400 uppercase tracking-wider transition-colors duration-300">@t('Status')</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white dark:text-gray-400 uppercase tracking-wider transition-colors duration-300">@t('Terakhir Update')</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white dark:text-gray-400 uppercase tracking-wider transition-colors duration-300">@t('Aksi')</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 transition-colors duration-300">
                        @foreach($contacts as $contact)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors {{ !$contact->admin_seen ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-[#4B5320] dark:bg-[#9acd32] flex items-center justify-center text-white dark:text-gray-900 font-semibold transition-colors duration-300">
                                            {{ strtoupper(substr($contact->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2 transition-colors duration-300">
                                            {{ $contact->user->name ?? 'Unknown' }}
                                            @if(!$contact->admin_seen)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                @t('Baru')
                                            </span>
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 transition-colors duration-300">{{ $contact->user->email ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 dark:text-gray-100 font-medium transition-colors duration-300">{{ $contact->subject ?: '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600 dark:text-gray-400 max-w-xs truncate transition-colors duration-300">
                                    {{ \Illuminate\Support\Str::limit($contact->message, 50) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($contact->status === 'open')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        @t('Menunggu')
                                    </span>
                                @elseif($contact->status === 'replied')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        @t('Dibalas')
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ ucfirst($contact->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 transition-colors duration-300">
                                {{ $contact->updated_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="{{ route('admin.contacts.show', $contact->id) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 rounded-lg hover:bg-[#3a4019] dark:hover:bg-[#7ab32e] transition-colors gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    @t('Detail')
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($contacts->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 transition-colors duration-300">
                {{ $contacts->links() }}
            </div>
            @endif
            @else
            <div class="text-center py-12">
                <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100 transition-colors duration-300">@t('Belum ada pesan')</h3>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 transition-colors duration-300">@t('Pesan dari pengguna akan muncul di sini')</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
