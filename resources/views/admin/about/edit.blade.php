@extends('layouts.app')

@section('title', 'Edit Tentang Kami - Lentera Aksara')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-[#2F4F4F] font-serif">@t('Edit Tentang Kami')</h1>
                <p class="text-gray-600 mt-2">@t('Kelola konten halaman "Tentang" yang ditampilkan di homepage')</p>
            </div>
            <a href="{{ route('welcome') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                @t('Lihat Halaman')
            </a>
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

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
            <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="p-8 space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            @t('Judul Halaman') <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $about->title ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4B5320] focus:border-transparent transition-all"
                               placeholder="@t('Misal: Tentang Lentera Aksara')"
                               required>
                        @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Image Preview -->
                    @if($about && $about->image)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">@t('Gambar Saat Ini')</label>
                        <div class="relative w-full max-w-md">
                            <img src="{{ asset('storage/' . $about->image) }}" 
                                 alt="Current about image" 
                                 class="w-full h-64 object-cover rounded-lg shadow-md">
                        </div>
                    </div>
                    @endif

                    <!-- Image Upload -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            @t('Upload Gambar Baru') <span class="text-gray-500">(@t('Opsional'))</span>
                        </label>
                        <div class="flex items-center justify-center w-full">
                            <label for="image" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">@t('Klik untuk upload')</span> @t('atau drag and drop')</p>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG, GIF (@t('Max 2MB'))</p>
                                </div>
                                <input id="image" 
                                       name="image" 
                                       type="file" 
                                       class="hidden" 
                                       accept="image/*"
                                       onchange="previewImage(event)">
                            </label>
                        </div>
                        @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <!-- Image Preview -->
                        <div id="imagePreview" class="mt-4 hidden">
                            <p class="text-sm font-medium text-gray-700 mb-2">@t('Preview'):</p>
                            <img id="previewImg" class="w-full max-w-md h-64 object-cover rounded-lg shadow-md" alt="Preview">
                        </div>
                    </div>

                    <!-- Content (Rich Text) -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                            @t('Konten') <span class="text-red-500">*</span>
                        </label>
                        <div class="mb-2 flex gap-2 flex-wrap border border-gray-300 rounded-t-lg p-2 bg-gray-50">
                            <button type="button" onclick="formatText('bold')" class="px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100" title="@t('Bold')">
                                <strong>B</strong>
                            </button>
                            <button type="button" onclick="formatText('italic')" class="px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100" title="@t('Italic')">
                                <em>I</em>
                            </button>
                            <button type="button" onclick="formatText('underline')" class="px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100" title="@t('Underline')">
                                <u>U</u>
                            </button>
                            <span class="border-l border-gray-300 mx-1"></span>
                            <button type="button" onclick="formatText('insertUnorderedList')" class="px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100" title="@t('Bullet List')">
                                • List
                            </button>
                            <button type="button" onclick="formatText('insertOrderedList')" class="px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100" title="@t('Numbered List')">
                                1. List
                            </button>
                            <span class="border-l border-gray-300 mx-1"></span>
                            <button type="button" onclick="formatHeading('h2')" class="px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100" title="@t('Heading 2')">
                                H2
                            </button>
                            <button type="button" onclick="formatHeading('h3')" class="px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100" title="@t('Heading 3')">
                                H3
                            </button>
                        </div>
                        <div id="editor" 
                             contenteditable="true"
                             class="w-full min-h-[400px] px-4 py-3 border border-gray-300 rounded-b-lg focus:ring-2 focus:ring-[#4B5320] focus:border-transparent transition-all overflow-y-auto prose prose-sm max-w-none"
                             style="white-space: pre-wrap;">{!! old('content', $about->content ?? '') !!}</div>
                        <textarea id="content" name="content" class="hidden" required></textarea>
                        @error('content')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-2">
                            💡 @t('Tips: Gunakan toolbar di atas untuk memformat teks. Konten mendukung HTML.')
                        </p>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 text-gray-700 hover:text-gray-900">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        @t('Kembali')
                    </a>
                    <button type="submit" 
                            id="submitBtn"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-[#4B5320] text-white font-medium rounded-lg hover:bg-[#3a4019] hover:shadow-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span id="submitBtnText">@t('Simpan Perubahan')</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Sync contenteditable div to hidden textarea before submit
const form = document.querySelector('form');
const submitBtn = document.getElementById('submitBtn');
const submitBtnText = document.getElementById('submitBtnText');

form.addEventListener('submit', function(e) {
    // Prevent double submission
    if (submitBtn.disabled) {
        e.preventDefault();
        return false;
    }
    
    const editor = document.getElementById('editor');
    const content = document.getElementById('content');
    
    // Sync content
    content.value = editor.innerHTML;
    
    // Validate content not empty
    if (editor.innerText.trim() === '') {
        e.preventDefault();
        alert('Konten tidak boleh kosong!');
        return false;
    }
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtnText.textContent = 'Menyimpan...';
    
    // Debug log
    console.log('Form submitting...');
    console.log('Title:', document.getElementById('title').value);
    console.log('Content length:', content.value.length);
    console.log('Content preview:', content.value.substring(0, 100));
    
    return true;
});

// Also sync on editor blur (when user leaves the editor)
document.getElementById('editor').addEventListener('blur', function() {
    const content = document.getElementById('content');
    content.value = this.innerHTML;
});

// Sync on editor input (real-time)
document.getElementById('editor').addEventListener('input', function() {
    const content = document.getElementById('content');
    content.value = this.innerHTML;
});

// Rich text formatting
function formatText(command) {
    document.execCommand(command, false, null);
    document.getElementById('editor').focus();
}

function formatHeading(tag) {
    document.execCommand('formatBlock', false, tag);
    document.getElementById('editor').focus();
}

// Image preview
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        // Validate file size (max 2MB)
        if (file.size > 2048 * 1024) {
            alert('Ukuran file terlalu besar! Max 2MB');
            event.target.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('imagePreview');
            const img = document.getElementById('previewImg');
            img.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

// Initialize: Make sure content is synced on page load
window.addEventListener('DOMContentLoaded', function() {
    const editor = document.getElementById('editor');
    const content = document.getElementById('content');
    content.value = editor.innerHTML;
    
    console.log('Page loaded. Initial content synced.');
});
</script>
@endsection
