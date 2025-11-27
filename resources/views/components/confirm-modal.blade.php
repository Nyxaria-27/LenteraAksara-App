<div x-data="{ open: false, title: '', description: '', onConfirm: null }" x-show="open" x-cloak @close-modal.window="open = false"
     class="absolute inset-0 z-50 flex items-center justify-center">
    <div class="relative z-10 inset-0 bg-black bg-opacity-50" x-show="open" @click="open = false"></div>

    <div class="bg-white rounded-lg shadow-xl max-w-lg w-full mx-4 z-50" x-show="open" x-transition>
        <div class="p-6">
            <h3 class="text-lg font-medium text-[#2F4F4F]" x-text="title"></h3>
            <p class="text-sm text-gray-600 mt-2" x-text="description"></p>

            <div class="mt-6 flex justify-end gap-3">
                <button @click="open = false; $dispatch('close-modal')" class="px-4 py-2 bg-gray-100 rounded-lg">Batal</button>
                <button @click="if(typeof onConfirm === 'function'){ onConfirm(); } open = false; $dispatch('close-modal')"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg">Hapus</button>
            </div>
        </div>
    </div>
</div>
