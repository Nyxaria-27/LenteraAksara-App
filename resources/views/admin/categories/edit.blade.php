@extends('layouts.app')
@section('title', 'Edit Kategori - Lentera Aksara')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-serif text-[#2F4F4F] dark:text-gray-100 transition-colors duration-300">@t('Edit Kategori')</h1>
            <p class="text-gray-600 dark:text-gray-400 transition-colors duration-300">@t('Ubah nama kategori untuk memperbarui klasifikasi buku.')</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-300">@t('Kembali')</a>
    </div>
</div>

@if($errors->any())
    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-400 text-red-800 rounded">
        <ul class="ml-5 list-disc">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="max-w-full bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 transition-colors duration-300">
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-2 text-sm text-[#2F4F4F] dark:text-gray-200 transition-colors duration-300">@t('Nama Kategori')</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg transition-colors duration-300" placeholder="@t('Contoh: Non-Fiksi')">
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="px-4 py-2 bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 rounded-lg hover:bg-[#2F4F4F] dark:hover:bg-[#7ab32e] transition-colors duration-300">@t('Simpan Perubahan')</button>
            <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 bg-[#2F4F4F] dark:bg-gray-700 text-white dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-300">@t('Batal')</a>
        </div>
    </form>
    <button type="button" data-id="{{ $category->id }}" data-name="{{ $category->name }}" id="editDeleteBtn" class="mt-4 bg-[#C0392B] dark:bg-red-600 text-white rounded-lg hover:bg-[#A93226] dark:hover:bg-red-500 px-4 py-2 transition-colors duration-300">@t('Hapus Kategori')</button>
    <form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="ml-auto hidden">
        @csrf
        @method('DELETE')
    </form>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reuse same modal structure as index - if modal not present, create one
    let modal = document.getElementById('categoryDeleteModal');
    if (!modal) {
        const modalEl = document.createElement('div');
        modalEl.innerHTML = `
        <div id="categoryDeleteModal" class="fixed inset-0 z-50 hidden items-center justify-center">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            <div class="relative z-10 bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4 transition-colors duration-300">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-[#2F4F4F] dark:text-gray-100 transition-colors duration-300" id="modalTitle">@t('Konfirmasi Hapus')</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 transition-colors duration-300" id="modalDesc">@t('Apakah Anda yakin ingin menghapus kategori ini? Aksi ini tidak dapat dibatalkan.')</p>
                    <div class="mt-6 flex justify-end gap-3">
                        <button id="modalCancel" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 rounded-lg transition-colors duration-300">@t('Batal')</button>
                        <button id="modalConfirm" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-500 transition-colors duration-300">@t('Hapus')</button>
                    </div>
                </div>
            </div>
        </div>
    `;
        document.body.appendChild(modalEl);
        modal = document.getElementById('categoryDeleteModal');
    }

    const editBtn = document.getElementById('editDeleteBtn');
    if (editBtn) {
        editBtn.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name || '';
            const currentDeleteForm = document.getElementById('delete-form-' + id);
            const modalTitle = document.getElementById('modalTitle');
            const modalDesc = document.getElementById('modalDesc');
            modalTitle.textContent = '@t("Hapus kategori")' + ': ' + name;
            modalDesc.textContent = '@t("Kategori yang dihapus tidak dapat dikembalikan. Jika kategori sedang digunakan oleh buku, penghapusan akan dibatalkan.")';
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // wire up confirm
            const modalConfirm = document.getElementById('modalConfirm');
            const modalCancel = document.getElementById('modalCancel');
            modalCancel.addEventListener('click', function() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
            modalConfirm.addEventListener('click', function() {
                if (currentDeleteForm) currentDeleteForm.submit();
            });
        });
    }
});
</script>
@endpush