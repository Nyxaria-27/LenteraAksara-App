@extends('layouts.app')
@section('title', 'Kelola Kategori - Lentera Aksara')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-serif text-[#2F4F4F]">@t('Kelola Kategori')</h1>
            <p class="text-gray-600">@t('Tambahkan, edit, atau hapus kategori buku.')</p>
        </div>
        <a href="#addCategory" onclick="document.getElementById('name').focus();" class="px-4 py-2 bg-[#4B5320] text-white rounded-lg hover:bg-[#2F4F4F] transition">+ @t('Kategori Baru')</a>
    </div>
</div>

@if(session('success'))
    @component('components.alert', ['type' => 'success', 'message' => session('success')])@endcomponent
@endif
@if(session('error'))
    @component('components.alert', ['type' => 'error', 'message' => session('error')])@endcomponent
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Add category -->
        <div class="lg:col-span-1 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 transition-colors duration-300">
        <h2 class="font-medium text-[#2F4F4F] dark:text-gray-100 mb-4">@t('Tambah Kategori')</h2>
        <form id="addCategoryForm" action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block mb-2 text-sm text-[#2F4F4F] dark:text-gray-200">@t('Nama Kategori')</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg" placeholder="@t('Contoh: Fiksi')">
                @error('name') <div class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</div> @enderror
            </div>
            <div class="flex items-center gap-3">
                <button id="addCategoryBtn" type="submit" class="px-4 py-2 bg-[#4B5320] dark:bg-[#9acd32] text-white dark:text-gray-900 rounded-lg hover:bg-[#2F4F4F] dark:hover:bg-[#7ab32e] transition">@t('Simpan')</button>
                <span id="addSpinner" class="hidden text-sm text-gray-500 dark:text-gray-400">@t('Mengirim...')</span>
            </div>
        </form>
    </div>

    <!-- Categories list -->
    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden transition-colors duration-300">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-[#F5F5F5] dark:bg-gray-700 flex items-center justify-between">
                <h3 class="font-medium text-[#2F4F4F] dark:text-gray-100">@t('Daftar Kategori')</h3>
                <div class="text-sm text-gray-600 dark:text-gray-400">@t('Total'): {{ $categories->total() }}</div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-white dark:bg-gray-800">
                        <tr>
                            <th class="text-left px-6 py-3 text-sm text-gray-500 dark:text-gray-400">@t('Nama')</th>
                            <th class="text-left px-6 py-3 text-sm text-gray-500 dark:text-gray-400">@t('Jumlah Buku')</th>
                            <th class="text-left px-6 py-3 text-sm text-gray-500 dark:text-gray-400">@t('Aksi')</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($categories as $category)
                        <tr class="hover:bg-[#F5F5F5] dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 text-[#2F4F4F] dark:text-gray-100">{{ $category->name }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $category->books_count }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-[#4B5320] dark:text-[#9acd32] hover:underline">@t('Edit')</a>
                                    <button type="button" data-id="{{ $category->id }}" data-name="{{ $category->name }}" class="delete-btn text-red-600 dark:text-red-400 hover:underline">@t('Hapus')</button>

                                    <form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">@t('Belum ada kategori.')</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // AJAX submit for add category
    const addForm = document.getElementById('addCategoryForm');
    const addBtn = document.getElementById('addCategoryBtn');
    const addSpinner = document.getElementById('addSpinner');

    if (addForm) {
        addForm.addEventListener('submit', function(e) {
            e.preventDefault();
            addBtn.setAttribute('disabled', 'disabled');
            addSpinner.classList.remove('hidden');

            const action = addForm.getAttribute('action');
            const formData = new FormData(addForm);

            fetch(action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            }).then(response => {
                // If the server redirected (typical Laravel behavior), follow it
                if (response.redirected) {
                    window.location = response.url;
                } else {
                    // Otherwise reload to get updated list (simple fallback)
                    window.location.reload();
                }
            }).catch(err => {
                console.error(err);
                window.location.reload();
            });
        });
    }

    // Delete modal handling
    const deleteButtons = document.querySelectorAll('.delete-btn');
    const modalEl = document.createElement('div');
    modalEl.innerHTML = `
        <div id="categoryDeleteModal" class="fixed inset-0 z-50 hidden items-center justify-center">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            <div class="relative z-10 bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-[#2F4F4F]" id="modalTitle">@t('Konfirmasi Hapus')</h3>
                    <p class="text-sm text-gray-600 mt-2" id="modalDesc">@t('Apakah Anda yakin ingin menghapus kategori ini? Aksi ini tidak dapat dibatalkan.')</p>
                    <div class="mt-6 flex justify-end gap-3">
                        <button id="modalCancel" class="px-4 py-2 bg-gray-100 rounded-lg">@t('Batal')</button>
                        <button id="modalConfirm" class="px-4 py-2 bg-red-600 text-white rounded-lg">@t('Hapus')</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(modalEl);

    const categoryDeleteModal = document.getElementById('categoryDeleteModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalDesc = document.getElementById('modalDesc');
    const modalCancel = document.getElementById('modalCancel');
    const modalConfirm = document.getElementById('modalConfirm');
    let currentDeleteForm = null;

    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name || '';
            currentDeleteForm = document.getElementById('delete-form-' + id);
            modalTitle.textContent = '@t("Hapus kategori")' + ': ' + name;
            modalDesc.textContent = '@t("Kategori yang dihapus tidak dapat dikembalikan. Jika kategori sedang digunakan oleh buku, penghapusan akan dibatalkan.")';
            categoryDeleteModal.classList.remove('hidden');
            categoryDeleteModal.classList.add('flex');
        });
    });

    modalCancel.addEventListener('click', function() {
        categoryDeleteModal.classList.add('hidden');
        categoryDeleteModal.classList.remove('flex');
    });

    modalConfirm.addEventListener('click', function() {
        if (currentDeleteForm) currentDeleteForm.submit();
    });
});
</script>
@endpush