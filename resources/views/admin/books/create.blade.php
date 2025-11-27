@extends('layouts.app')
@section('title', 'Tambah Buku - Lentera Aksara')

@push('styles')
<style>
  :root{
    --color-text: #2F4F4F;
    --color-accent: #4B5320;
    --color-warm: #D2B48C;
  }

  /* Minor tweak for file input focus ring */
  .file-input-focus:focus + .file-label {
    box-shadow: 0 0 0 4px rgba(75,83,32,0.12);
  }

  /* Smooth image appearing */
  .cover-img { transition: opacity .25s ease, transform .25s ease; }
  .cover-img.show { opacity: 1; transform: none; }
  .cover-img.hide { opacity: 0; transform: scale(.98); }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="relative bg-gradient-to-r from-[var(--color-accent)] to-[#2F4F4F] text-white rounded-xl mb-8 p-6 overflow-hidden">
    <div class="relative z-10">
        <h1 class="text-2xl sm:text-3xl font-serif mb-1">@t('Tambah Buku Baru')</h1>
        <p class="text-sm text-white/90">@t('Lengkapi informasi buku untuk menambahkannya ke katalog Lentera Aksara')</p>
    </div>
    <div class="absolute right-0 top-0 h-full w-48 md:w-64 bg-white opacity-10 transform -skew-x-12 pointer-events-none"></div>
</div>

@if($errors->any())
    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 text-red-800 rounded-lg">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 mt-0.5 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h3 class="text-sm font-semibold">@t('Terdapat beberapa kesalahan')</h3>
                <ul class="mt-2 ml-4 list-disc text-sm">
                    @foreach($errors->all() as $error)
                        <li class="mt-1">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

<div class="max-w-4xl mx-auto">
    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden transition-colors duration-300">
        @csrf

        <!-- Cover area -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
            <div>
                <label for="cover" class="block text-sm font-medium text-[var(--color-text)] dark:text-gray-200 mb-2">@t('Sampul Buku')</label>

                <div class="relative rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600 bg-[#F5F5F5] dark:bg-gray-700 h-60 md:h-72 flex items-center justify-center">
                    <!-- Placeholder / preview -->
                    <div id="coverPreview" class="w-full h-full flex items-center justify-center">
                        <div class="text-center px-4">
                            <svg class="mx-auto w-12 h-12 text-gray-400 dark:text-gray-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <div class="text-sm text-gray-500 dark:text-gray-400">@t('Klik untuk memilih file sampul')</div>
                        </div>
                    </div>

                    <!-- Actual file input (covers entire card but invisible) -->
                    <input
                        id="cover"
                        name="cover"
                        type="file"
                        accept="image/*"
                        aria-label="@t('Pilih sampul buku')"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer file-input-focus"
                        onchange="previewCover(event)">
                </div>

                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">@t('Rekomendasi: rasio 3:4, ukuran maksimal 2MB.')</p>
            </div>

            <!-- Form fields -->
            <div class="md:col-span-2">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Title (full width) -->
                    <div class="sm:col-span-2">
                        <label for="title" class="block mb-2 text-sm font-medium text-[var(--color-text)] dark:text-gray-200">@t('Judul Buku')</label>
                        <input id="title" name="title" type="text" value="{{ old('title') }}" placeholder="@t('Masukkan judul buku')"
                            class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-[var(--color-accent)] focus:border-transparent transition-shadow" required>
                    </div>

                    <div>
                        <label for="author" class="block mb-2 text-sm font-medium text-[var(--color-text)] dark:text-gray-200">@t('Penulis')</label>
                        <input id="author" name="author" type="text" value="{{ old('author') }}" placeholder="@t('Nama penulis')"
                            class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-[var(--color-accent)] focus:border-transparent transition-shadow" required>
                    </div>

                    <div>
                        <label for="isbn" class="block mb-2 text-sm font-medium text-[var(--color-text)] dark:text-gray-200">ISBN</label>
                        <input id="isbn" name="isbn" type="text" value="{{ old('isbn') }}" placeholder="9783161484100"
                            class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-[var(--color-accent)] focus:border-transparent transition-shadow">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">@t('Masukkan 13 digit ISBN tanpa strip (opsional).')</p>
                    </div>

                    <div>
                        <label for="price" class="block mb-2 text-sm font-medium text-[var(--color-text)] dark:text-gray-200">@t('Harga (Rp)')</label>
                        <input id="price" name="price" type="number" min="0" value="{{ old('price') }}" placeholder="150000"
                            class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-[var(--color-accent)] focus:border-transparent transition-shadow">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">@t('Gunakan angka saja (tanpa format).')</p>
                    </div>

                    <div>
                        <label for="stock" class="block mb-2 text-sm font-medium text-[var(--color-text)] dark:text-gray-200">@t('Stok')</label>
                        <input id="stock" name="stock" type="number" min="0" value="{{ old('stock', 0) }}" placeholder="0"
                            class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-[var(--color-accent)] focus:border-transparent transition-shadow">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="categories" class="block mb-2 text-sm font-medium text-[var(--color-text)] dark:text-gray-200">@t('Kategori')</label>
                        <select id="categories" name="categories[]" multiple class="w-full min-h-[120px] px-3 py-2 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-[var(--color-accent)] focus:border-transparent">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (collect(old('categories'))->contains($category->id)) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">@t('Tahan Ctrl/Cmd untuk memilih beberapa kategori.')</p>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description" class="block mb-2 text-sm font-medium text-[var(--color-text)]">@t('Deskripsi')</label>
                        <textarea id="description" name="description" rows="4" placeholder="@t('Deskripsi atau sinopsis buku')" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[var(--color-accent)] focus:border-transparent transition-shadow">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action buttons -->
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-white/50 dark:bg-gray-800/50 flex flex-col-reverse md:flex-row items-center justify-between gap-3">
            <div class="w-full md:w-auto flex gap-3">
                <a href="{{ route('admin.books.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors w-full md:w-auto text-center">@t('Batal')</a>

                <button type="submit" class="px-5 py-2 bg-[var(--color-accent)] dark:bg-[#9acd32] text-white dark:text-gray-900 rounded-lg hover:bg-[#3f4618] dark:hover:bg-[#7ab32e] transition-colors w-full md:w-auto flex items-center justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    @t('Simpan Buku')
                </button>
            </div>

            <p class="text-xs text-gray-500 dark:text-gray-400">@t('Pastikan semua informasi sudah benar sebelum menyimpan.')</p>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function previewCover(event) {
    const file = event.target.files[0];
    const previewWrapper = document.getElementById('coverPreview');

    if (!file) {
        // reset to placeholder
        previewWrapper.innerHTML = `
            <div class="text-center px-4">
                <svg class="mx-auto w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <div class="text-sm text-gray-500">@t('Klik untuk memilih file sampul')</div>
            </div>
        `;
        return;
    }

    // validate file size (2MB)
    const maxSize = 2 * 1024 * 1024;
    if (file.size > maxSize) {
        alert('@t("Ukuran file terlalu besar. Maksimal 2MB.")');
        event.target.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        previewWrapper.innerHTML = `<img src="${e.target.result}" alt="Cover preview" class="w-full h-full object-cover cover-img show">`;
    }
    reader.readAsDataURL(file);
}
</script>
@endpush
