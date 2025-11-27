# ========================================
# TUTORIAL: Cara Show/Hide Wishlist
# ========================================

## CARA 1: EDIT .ENV (PALING MUDAH!)
## =====================================

### HIDE Wishlist (untuk TO USK):
1. Buka file `.env`
2. Tambahkan atau edit baris ini:
   
   FEATURE_WISHLIST=false

3. Clear cache:
   php artisan config:clear
   php artisan view:clear

4. Refresh browser (Ctrl + F5)
5. Wishlist icon 💚 akan HILANG dari navbar!


### SHOW Wishlist (setelah TO USK):
1. Buka file `.env`
2. Edit baris menjadi:
   
   FEATURE_WISHLIST=true

3. Clear cache:
   php artisan config:clear
   php artisan view:clear

4. Refresh browser (Ctrl + F5)
5. Wishlist icon 💚 akan MUNCUL kembali!


## CARA 2: MANUAL EDIT CONFIG
## ============================

Jika tidak ada `.env`, edit langsung di:
`config/features.php`

Cari baris:
'wishlist' => env('FEATURE_WISHLIST', true),

Ganti menjadi:
'wishlist' => env('FEATURE_WISHLIST', false),  // ← Hide
atau
'wishlist' => env('FEATURE_WISHLIST', true),   // ← Show


## CARA 3: GUNAKAN TOGGLE SCRIPT
## ===============================

Jalankan:
toggle-features.bat

Pilih [1] untuk hide semua
Pilih [2] untuk show semua


## APA YANG TERJADI DI BELAKANG LAYAR?
## =====================================

1. Di Blade Template (layouts/app.blade.php):

   @if(config('features.wishlist'))
       <!-- Wishlist Icon -->
       <a href="{{ route('wishlist.index') }}">💚</a>
   @endif

2. Jika FEATURE_WISHLIST=false:
   - Block code di dalam @if TIDAK akan di-render
   - Icon wishlist TIDAK muncul di HTML
   - Route wishlist tetap ada, tapi tidak ada UI untuk akses

3. Jika FEATURE_WISHLIST=true:
   - Block code di-render normal
   - Icon wishlist muncul
   - User bisa akses wishlist


## LOKASI WISHLIST DI KODE
## ========================

### Navbar (Icon 💚):
File: resources/views/layouts/app.blade.php
Line: ~391-403

Code:
@if(config('features.wishlist'))
    <a href="{{ route('wishlist.index') }}">
        <!-- Heart Icon -->
    </a>
@endif


### Book Detail Page (Button Add to Wishlist):
File: resources/views/books/show.blade.php
(Perlu ditambahkan feature flag jika belum ada)


### Wishlist Index Page:
File: resources/views/user/wishlist/index.blade.php
(Halaman ini akan error 404 jika route di-disable)


## ADVANCED: HIDE ROUTE JUGA
## ===========================

Jika ingin route wishlist juga di-disable:

Edit: routes/web.php

Wrap route wishlist dengan feature check:

if (config('features.wishlist')) {
    Route::middleware(['auth'])->prefix('wishlist')->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/add', [WishlistController::class, 'add'])->name('wishlist.add');
        Route::delete('/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    });
}

Dengan cara ini:
- UI hidden ✅
- Route disabled ✅
- User tidak bisa akses via URL ✅


## CONTOH PENGGUNAAN DI CONTROLLER
## =================================

File: app/Http/Controllers/BookController.php

public function show($id)
{
    $book = Book::findOrFail($id);
    
    // Load wishlist status hanya jika fitur enabled
    if (config('features.wishlist') && auth()->check()) {
        $book->is_wishlisted = auth()->user()
            ->wishlists()
            ->where('book_id', $id)
            ->exists();
    }
    
    return view('books.show', compact('book'));
}


## TESTING CHECKLIST
## ==================

### Test Hide (FEATURE_WISHLIST=false):
□ Navbar tidak ada icon 💚
□ Book detail page tidak ada button "Add to Wishlist"
□ Akses URL /wishlist redirect atau 404
□ Database wishlist tetap utuh (data tidak hilang)

### Test Show (FEATURE_WISHLIST=true):
□ Navbar muncul icon 💚
□ Book detail page ada button "Add to Wishlist"
□ Bisa akses /wishlist dan lihat daftar
□ Bisa add/remove wishlist


## TROUBLESHOOTING
## ================

Problem: Sudah edit .env tapi wishlist masih muncul
Solution:
1. php artisan config:clear
2. php artisan view:clear
3. php artisan cache:clear
4. Hard refresh: Ctrl + Shift + F5

Problem: Error "config('features.wishlist') not found"
Solution:
1. Pastikan file config/features.php ada
2. Run: php artisan config:clear

Problem: Route wishlist error 404
Solution:
- Ini normal jika route juga di-disable
- Atau pastikan WishlistController ada


## BEST PRACTICES
## ===============

✅ DO:
- Edit .env untuk toggle (mudah di-revert)
- Clear cache setiap kali edit config
- Test di browser incognito untuk pastikan cache clear
- Dokumentasikan fitur yang di-hide

❌ DON'T:
- Jangan hapus code wishlist dari file
- Jangan edit langsung di config/features.php (gunakan .env)
- Jangan commit .env ke git (sudah di .gitignore)


## RINGKASAN 1 MENIT
## ===================

HIDE:
1. Edit .env → FEATURE_WISHLIST=false
2. php artisan config:clear
3. Refresh → Icon 💚 hilang!

SHOW:
1. Edit .env → FEATURE_WISHLIST=true
2. php artisan config:clear
3. Refresh → Icon 💚 muncul!

DONE! 🎉
