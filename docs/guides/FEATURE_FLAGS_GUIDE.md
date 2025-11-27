# 🎯 Feature Flags Guide - Lentera Aksara

## 📋 Overview
Sistem feature flags memungkinkan Anda untuk **hide/show fitur** tanpa menghapus kode. Sangat berguna untuk presentasi TO USK!

---

## 🚀 Quick Start - Hide Challenge Features

### **Untuk TO USK (Minimal Version)**

Edit file `.env` di root project:

```env
# ===== FEATURE FLAGS UNTUK TO USK =====
# Set false untuk hide fitur challenge

FEATURE_TRANSLATION=false     # ❌ Hide language switcher (🇮🇩 🇬🇧)
FEATURE_DARK_MODE=false       # ❌ Hide dark mode toggle (🌙 ☀️)
FEATURE_REVIEWS=false         # ❌ Hide rating & review buku
FEATURE_WISHLIST=false        # ❌ Hide wishlist/favorit (💚)
FEATURE_AOS_ANIMATIONS=false  # ❌ Disable scroll animations (AOS)
FEATURE_PDF_INVOICE=false     # ❌ Hide download PDF invoice

# Optional - Fitur lain yang bisa di-hide
FEATURE_CART=false            # ❌ Hide shopping cart (🛒)
FEATURE_ORDERS=false          # ❌ Hide order management
FEATURE_NOTIFICATIONS=false   # ❌ Hide notification bell (🔔)
FEATURE_SEARCH=false          # ❌ Hide search bar
FEATURE_CONTACT=false         # ❌ Hide contact form
```

**Setelah edit `.env`:**
```bash
php artisan config:clear
php artisan view:clear
```

Refresh browser dengan `Ctrl + F5` dan semua fitur challenge akan **tersembunyi**! ✨

---

## ✅ After TO USK (Full Features)

Kembalikan semua fitur dengan edit `.env`:

```env
# ===== FULL FEATURES ENABLED =====
FEATURE_TRANSLATION=true      # ✅ Show language switcher
FEATURE_DARK_MODE=true        # ✅ Show dark mode toggle
FEATURE_REVIEWS=true          # ✅ Show rating & review
FEATURE_WISHLIST=true         # ✅ Show wishlist
FEATURE_AOS_ANIMATIONS=true   # ✅ Enable scroll animations
FEATURE_PDF_INVOICE=true      # ✅ Show PDF download
FEATURE_CART=true             # ✅ Show cart
FEATURE_ORDERS=true           # ✅ Show orders
FEATURE_NOTIFICATIONS=true    # ✅ Show notifications
FEATURE_SEARCH=true           # ✅ Show search
FEATURE_CONTACT=true          # ✅ Show contact
```

---

## 🛠️ Technical Implementation

### **1. Config File: `config/features.php`**

```php
return [
    // Challenge features (dapat di-hide)
    'translation' => env('FEATURE_TRANSLATION', true),
    'dark_mode' => env('FEATURE_DARK_MODE', true),
    'reviews' => env('FEATURE_REVIEWS', true),
    'wishlist' => env('FEATURE_WISHLIST', true),
    'cart' => env('FEATURE_CART', true),
    'orders' => env('FEATURE_ORDERS', true),
    'search' => env('FEATURE_SEARCH', true),
    'contact' => env('FEATURE_CONTACT', true),
    'notifications' => env('FEATURE_NOTIFICATIONS', true),
    'aos_animations' => env('FEATURE_AOS_ANIMATIONS', true),
    'pdf_invoice' => env('FEATURE_PDF_INVOICE', true),
    
    // Core features (tidak bisa dimatikan)
    'books_catalog' => true,
    'categories' => true,
    'about_page' => true,
    'authentication' => true,
];
```

### **2. Helper Functions: `app/Helpers/FeatureHelper.php`**

#### **Check if feature enabled:**
```php
if (feature_enabled('wishlist')) {
    // Show wishlist
}
```

#### **Check if feature disabled:**
```php
if (feature_disabled('dark_mode')) {
    // Hide dark mode toggle
}
```

#### **AOS Animation Helper:**
```php
// In Blade templates
<div {!! aos('fade-up', 100) !!}>Content</div>

// Output when enabled: data-aos="fade-up" data-aos-delay="100"
// Output when disabled: (empty string)
```

---

## 📝 Usage in Blade Templates

### **Example 1: Hide Language Switcher**

```blade
@if(config('features.translation'))
    <div class="language-switcher">
        <a href="{{ route('language.switch', 'id') }}">🇮🇩</a>
        <a href="{{ route('language.switch', 'en') }}">🇬🇧</a>
    </div>
@endif
```

### **Example 2: Hide Dark Mode Toggle**

```blade
@if(config('features.dark_mode'))
    <button id="darkModeToggle">
        🌙 Toggle Dark Mode
    </button>
@endif
```

### **Example 3: Hide Wishlist Icon**

```blade
@if(config('features.wishlist'))
    <a href="{{ route('wishlist.index') }}">
        💚 Wishlist ({{ $wishlistCount }})
    </a>
@endif
```

### **Example 4: Hide Reviews Section**

```blade
@if(config('features.reviews'))
    <div class="reviews-section">
        <h3>Customer Reviews</h3>
        @foreach($book->reviews as $review)
            <div class="review">{{ $review->comment }}</div>
        @endforeach
    </div>
@endif
```

### **Example 5: Conditional AOS Animations**

```blade
{{-- Old way (always show) --}}
<div data-aos="fade-up" data-aos-delay="100">Content</div>

{{-- New way (conditional) --}}
<div {!! aos('fade-up', 100) !!}>Content</div>
```

---

## 🎯 Files Already Modified

✅ **Navbar** (`resources/views/layouts/app.blade.php`):
- Language switcher wrapped with `@if(config('features.translation'))`
- Dark mode toggle wrapped with `@if(config('features.dark_mode'))`
- Wishlist icon wrapped with `@if(config('features.wishlist'))`
- Cart icon wrapped with `@if(config('features.cart'))`
- Orders icon wrapped with `@if(config('features.orders'))`
- Notifications wrapped with `@if(config('features.notifications'))`

✅ **Welcome Page** (`resources/views/welcome.blade.php`):
- All `data-aos` replaced with `{!! aos() !!}` helper
- Reviews section wrapped with `@if(config('features.reviews'))`

---

## 📊 Feature Comparison

| Feature | TO USK (Hidden) | After TO USK (Full) |
|---------|----------------|---------------------|
| Translation 🇮🇩🇬🇧 | ❌ | ✅ |
| Dark Mode 🌙 | ❌ | ✅ |
| Reviews ⭐ | ❌ | ✅ |
| Wishlist 💚 | ❌ | ✅ |
| AOS Animations | ❌ | ✅ |
| PDF Invoice 📄 | ❌ | ✅ |
| Cart 🛒 | ❌ (Optional) | ✅ |
| Orders 📦 | ❌ (Optional) | ✅ |
| Notifications 🔔 | ❌ (Optional) | ✅ |

---

## 🔍 Checking Current Feature State

### **In Blade Templates:**
```blade
@if(config('features.translation'))
    Translation is ENABLED ✅
@else
    Translation is DISABLED ❌
@endif
```

### **In Controllers:**
```php
if (config('features.wishlist')) {
    // Load wishlist data
    $wishlist = Wishlist::where('user_id', auth()->id())->get();
}
```

### **In Routes:**
```php
// Conditional route registration
if (config('features.cart')) {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
}
```

---

## 💡 Best Practices

1. **Non-Destructive** - Jangan hapus kode, cukup hide dengan feature flags
2. **Version Control** - `.env` tidak di-commit, jadi aman untuk toggle
3. **Easy Rollback** - Tinggal ubah `.env` untuk enable/disable fitur
4. **Clear Cache** - Selalu jalankan `php artisan config:clear` setelah edit `.env`
5. **Test Both States** - Test dengan fitur ON dan OFF sebelum presentasi

---

## 🎓 Challenge Mapping

Berdasarkan soal challenge, ini mapping fitur yang sudah di-hide:

| Challenge Requirement | Feature Flag | Status |
|-----------------------|--------------|--------|
| **Dark mode toggle** | `dark_mode` | ✅ Implemented |
| **AOS animations** | `aos_animations` | ✅ Implemented |
| **Rating & Review** | `reviews` | ✅ Implemented |
| **Wishlist** | `wishlist` | ✅ Implemented |
| **Auto-translation** | `translation` | ✅ Implemented |
| **PDF Invoice** | `pdf_invoice` | ✅ Config ready |
| **Cart & Checkout** | `cart` | ✅ Implemented |
| **Order Management** | `orders` | ✅ Implemented |
| **Notifications** | `notifications` | ✅ Implemented |
| **Search & Filter** | `search` | ✅ Config ready |
| **Contact Form** | `contact` | ✅ Config ready |

---

## 📞 Support

Jika ada pertanyaan atau issue, check:
1. Apakah `.env` sudah di-edit dengan benar?
2. Sudah run `php artisan config:clear`?
3. Sudah refresh browser dengan `Ctrl + F5`?
4. Check `config/features.php` untuk list lengkap feature flags

---

## 🎉 Summary

✅ **6 Challenge Features** siap di-hide untuk TO USK:
1. Translation (🇮🇩 🇬🇧)
2. Dark Mode (🌙)
3. Reviews (⭐)
4. Wishlist (💚)
5. AOS Animations
6. PDF Invoice (📄)

✅ **5 Optional Features** juga bisa di-hide:
7. Cart (🛒)
8. Orders (📦)
9. Notifications (🔔)
10. Search (🔍)
11. Contact (📧)

**Total: 11 Features** dengan toggle ON/OFF hanya dengan edit `.env`! 🚀

---

**Made with ❤️ for TO USK Success!**
