<div>
    <!-- Always remember that you are absolutely unique. Just like everyone else. - Margaret Mead -->
</div>
<!-- Search (desktop) di navbar diatas auth cta -->
                        <form action="{{ route('books.search') }}" method="GET" class="hidden md:flex items-center bg-white rounded-full shadow-sm overflow-hidden">
                            <input type="search" name="q" placeholder="Cari judul atau penulis..." class="px-3 py-2 text-sm outline-none w-60" />
                            <button type="submit" class="px-4 py-2 text-sm font-medium" style="background-color:var(--color-warm); color:var(--color-text);">Cari</button>
                        </form>