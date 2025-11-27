# 🎯 DEMO PRAKTIS: Hide/Show Wishlist Feature

## 📺 Video Tutorial (Step-by-Step)

### **SCENARIO: TO USK besok, ingin hide Wishlist**

---

## 🎬 **TAKE 1: Hide Wishlist (5 Detik!)**

### **Langkah 1: Edit .env**
```bash
# Buka file .env di root project
code .env

# Atau notepad:
notepad .env
```

### **Langkah 2: Tambah/Edit Baris Ini**
```env
# Cari atau tambahkan baris ini:
FEATURE_WISHLIST=false
```

**Contoh lengkap di .env:**
```env
APP_NAME="Lentera Aksara"
APP_ENV=local
APP_DEBUG=true
# ... other settings ...

# === FEATURE FLAGS ===
FEATURE_WISHLIST=false    👈 TAMBAHKAN INI!
```

### **Langkah 3: Clear Cache**
```bash
cd c:\laragon\www\LenteraAksara
php artisan config:clear
php artisan view:clear
```

### **Langkah 4: Refresh Browser**
```
Press: Ctrl + F5
```

### **Hasil:**
✅ Icon 💚 HILANG dari navbar!  
✅ Button "Add to Wishlist" HILANG!  
✅ Halaman wishlist tidak bisa diakses!

---

## 🎬 **TAKE 2: Show Wishlist (Setelah TO USK)**

### **Langkah 1: Edit .env**
```env
FEATURE_WISHLIST=true    👈 GANTI MENJADI true
```

### **Langkah 2: Clear Cache**
```bash
php artisan config:clear
php artisan view:clear
```

### **Langkah 3: Refresh Browser**
```
Press: Ctrl + F5
```

### **Hasil:**
✅ Icon 💚 MUNCUL kembali!  
✅ Button "Add to Wishlist" MUNCUL!  
✅ Halaman wishlist bisa diakses!

---

## 📍 **Lokasi Wishlist di Kode (Reference)**

### **1. Navbar Icon (💚)**
📁 File: `resources/views/layouts/app.blade.php`  
📍 Line: ~391-403

```php
@if(config('features.wishlist'))
    <!-- Wishlist Link with Badge -->
    <a href="{{ route('wishlist.index') }}" 
       class="relative p-2 rounded-lg hover:bg-gray-100" 
       title="@t('Wishlist')">
        <svg class="w-5 h-5"><!-- Heart Icon --></svg>
        @if(isset($wishlistCount) && $wishlistCount > 0)
            <span class="badge">{{ $wishlistCount }}</span>
        @endif
    </a>
@endif
```

**Penjelasan:**
- `@if(config('features.wishlist'))` = Cek apakah wishlist enabled
- Jika `false` → seluruh block tidak di-render
- Jika `true` → icon muncul normal

---

### **2. Routes (Backend)**
📁 File: `routes/web.php`  
📍 Line: ~59-62

```php
// Wishlist routes
Route::post('/wishlist/toggle/{bookId}', [WishlistController::class, 'toggle'])
    ->name('wishlist.toggle');
Route::get('/wishlist', [WishlistController::class, 'index'])
    ->name('wishlist.index');
Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])
    ->name('wishlist.destroy');
```

**Optional: Wrap dengan feature flag juga**
```php
if (config('features.wishlist')) {
    Route::post('/wishlist/toggle/{bookId}', [WishlistController::class, 'toggle'])
        ->name('wishlist.toggle');
    Route::get('/wishlist', [WishlistController::class, 'index'])
        ->name('wishlist.index');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])
        ->name('wishlist.destroy');
}
```

---

### **3. Navbar Composer (Data Injection)**
📁 File: `app/View/Composers/NavbarComposer.php`

**Before (Always load wishlist count):**
```php
public function compose(View $view)
{
    if (!auth()->check()) {
        return;
    }

    $userId = auth()->id();
    
    $view->with([
        'cartCount' => CartItem::whereHas('cart', fn($q) => $q->where('user_id', $userId))->count(),
        'wishlistCount' => Wishlist::where('user_id', $userId)->count(), // Always
        // ...
    ]);
}
```

**After (Conditional load):**
```php
public function compose(View $view)
{
    if (!auth()->check()) {
        return;
    }

    $userId = auth()->id();
    
    $data = [
        'cartCount' => CartItem::whereHas('cart', fn($q) => $q->where('user_id', $userId))->count(),
        // ... other data
    ];
    
    // Only load wishlist count if feature enabled
    if (config('features.wishlist')) {
        $data['wishlistCount'] = Wishlist::where('user_id', $userId)->count();
    }
    
    $view->with($data);
}
```

---

## 🧪 **Testing Script**

### **Test 1: Verifikasi Hide**
```bash
# 1. Set wishlist ke false
echo "FEATURE_WISHLIST=false" >> .env

# 2. Clear cache
php artisan config:clear
php artisan view:clear

# 3. Test di browser
# - Buka http://localhost/
# - Login sebagai user
# - Check navbar → Tidak ada icon 💚
# - Try akses /wishlist → Error atau redirect

# ✅ PASS: Wishlist berhasil di-hide!
```

### **Test 2: Verifikasi Show**
```bash
# 1. Set wishlist ke true
# Edit .env: FEATURE_WISHLIST=true

# 2. Clear cache
php artisan config:clear
php artisan view:clear

# 3. Test di browser
# - Refresh page
# - Check navbar → Ada icon 💚
# - Click icon → Bisa akses wishlist page
# - Add item to wishlist → Berfungsi normal

# ✅ PASS: Wishlist berhasil ditampilkan!
```

---

## 📊 **Visual Comparison**

### **BEFORE (FEATURE_WISHLIST=false):**
```
Navbar:
[Beranda] [Katalog] [Kontak]  [🔔] [📦] [🛒] [👤]
                                ↑    ↑    ↑
                              Notif Order Cart
                              (NO WISHLIST!)
```

### **AFTER (FEATURE_WISHLIST=true):**
```
Navbar:
[Beranda] [Katalog] [Kontak]  [🔔] [📦] [🛒] [💚] [👤]
                                ↑    ↑    ↑    ↑
                              Notif Order Cart Wishlist
                              (WISHLIST MUNCUL!)
```

---

## 🎓 **Aplikasi untuk Challenge Lain**

### **Contoh: Hide REVIEWS**

```env
# .env
FEATURE_REVIEWS=false
```

Then di code:
```php
// resources/views/books/show.blade.php
@if(config('features.reviews'))
    <!-- Reviews Section -->
    <div class="reviews">
        <!-- Rating stars, review form, etc -->
    </div>
@endif
```

### **Contoh: Hide DARK MODE**

```env
# .env
FEATURE_DARK_MODE=false
```

Then di code:
```php
// resources/views/layouts/app.blade.php
@if(config('features.dark_mode'))
    <button id="darkModeToggle">🌙</button>
@endif
```

### **Contoh: Hide TRANSLATION**

```env
# .env
FEATURE_TRANSLATION=false
```

Then di code:
```php
// resources/views/layouts/app.blade.php
@if(config('features.translation'))
    <div class="language-switcher">
        🇮🇩 🇬🇧
    </div>
@endif
```

---

## 🚨 **Common Mistakes & Fixes**

### **Mistake 1: Edit config/features.php langsung**
❌ DON'T:
```php
// config/features.php
'wishlist' => false,  // ← Jangan edit disini!
```

✅ DO:
```env
# .env
FEATURE_WISHLIST=false  // ← Edit disini!
```

**Why?** `.env` tidak di-commit ke Git, lebih flexible!

---

### **Mistake 2: Lupa clear cache**
```bash
# Harus jalankan ini setiap edit .env:
php artisan config:clear
php artisan view:clear
```

---

### **Mistake 3: Typo di .env**
❌ Wrong:
```env
FEATURE_WHISLIST=false    // ← Typo "WHIS"
feature_wishlist=false     // ← Lowercase
FEATURE_WISHLIST = false   // ← Extra spaces
```

✅ Correct:
```env
FEATURE_WISHLIST=false     // ← Exact!
```

---

## 💡 **Pro Tips**

### **Tip 1: Batch Hide Multiple Features**
```env
# .env - TO USK MODE
FEATURE_WISHLIST=false
FEATURE_REVIEWS=false
FEATURE_DARK_MODE=false
FEATURE_TRANSLATION=false
FEATURE_AOS_ANIMATIONS=false
FEATURE_PDF_INVOICE=false
```

### **Tip 2: Use Toggle Script**
```bash
# Quick toggle all features
.\toggle-features.bat

# Choose:
# [1] TO USK MODE  → Hide all
# [2] FULL MODE    → Show all
```

### **Tip 3: Document Your Changes**
```env
# .env
# === TO USK PREPARATION (2025-01-15) ===
# Hiding advanced features for presentation
FEATURE_WISHLIST=false     # Hide untuk fokus ke CRUD
FEATURE_REVIEWS=false      # Terlalu kompleks untuk demo
```

---

## 🎉 **Kesimpulan**

### **Untuk Hide 1 Fitur (Wishlist):**
1. Edit `.env` → `FEATURE_WISHLIST=false`
2. Run `php artisan config:clear`
3. Refresh browser
4. Done! Icon 💚 hilang

### **Untuk Show 1 Fitur (Wishlist):**
1. Edit `.env` → `FEATURE_WISHLIST=true`
2. Run `php artisan config:clear`
3. Refresh browser
4. Done! Icon 💚 muncul

### **Keuntungan:**
✅ Tidak hapus kode (non-destructive)  
✅ Toggle cepat (5 detik)  
✅ Mudah revert  
✅ Data wishlist tetap aman di database  

---

**Total Time: 30 detik untuk hide/show 1 fitur! 🚀**
