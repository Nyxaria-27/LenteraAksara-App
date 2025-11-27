# 🎯 Quick Guide - Feature Toggle untuk TO USK

## 🚀 Cara Tercepat (3 Langkah!)

### **Untuk TO USK (Hide Challenge Features):**

**Windows CMD/PowerShell:**
```bash
# Double-click file ini:
toggle-features.bat

# Atau jalankan PowerShell script:
.\toggle-features.ps1
```

**Manual (Edit `.env`):**
```env
FEATURE_TRANSLATION=false
FEATURE_DARK_MODE=false
FEATURE_REVIEWS=false
FEATURE_WISHLIST=false
FEATURE_AOS_ANIMATIONS=false
FEATURE_PDF_INVOICE=false
```

**Then run:**
```bash
php artisan config:clear
php artisan view:clear
```

**Refresh browser dengan `Ctrl + F5`**

---

## ✅ Setelah TO USK (Show All Features)

**Windows:**
```bash
# Double-click:
toggle-features.bat
# Pilih option [2] FULL MODE
```

**Manual:**
```env
FEATURE_TRANSLATION=true
FEATURE_DARK_MODE=true
FEATURE_REVIEWS=true
FEATURE_WISHLIST=true
FEATURE_AOS_ANIMATIONS=true
FEATURE_PDF_INVOICE=true
```

---

## 📋 Fitur yang Bisa Di-Hide

✅ **6 Challenge Features Utama:**
1. 🌐 **Translation** - Bahasa Indonesia ↔ English
2. 🌙 **Dark Mode** - Toggle light/dark theme
3. ⭐ **Reviews** - Rating & review buku
4. 💚 **Wishlist** - Daftar favorit buku
5. ✨ **AOS Animations** - Scroll animations
6. 📄 **PDF Invoice** - Download invoice PDF

✅ **5 Features Tambahan:**
7. 🛒 **Cart** - Shopping cart
8. 📦 **Orders** - Order management
9. 🔔 **Notifications** - Real-time notifications
10. 🔍 **Search** - Advanced search
11. 📧 **Contact** - Contact form

---

## 📁 File-File Penting

- `config/features.php` - Config feature flags
- `app/Helpers/FeatureHelper.php` - Helper functions
- `.env.to-usk` - Config untuk TO USK (minimal)
- `.env.full` - Config full features
- `toggle-features.bat` - Quick toggle script (Windows)
- `toggle-features.ps1` - PowerShell toggle script
- `FEATURE_FLAGS_GUIDE.md` - Dokumentasi lengkap

---

## 🎓 Mapping Challenge Requirements

| Challenge | Feature Flag | Status |
|-----------|--------------|--------|
| Dark mode toggle | `FEATURE_DARK_MODE` | ✅ |
| AOS animations | `FEATURE_AOS_ANIMATIONS` | ✅ |
| Rating & review | `FEATURE_REVIEWS` | ✅ |
| Wishlist | `FEATURE_WISHLIST` | ✅ |
| Auto-translation | `FEATURE_TRANSLATION` | ✅ |
| PDF Invoice | `FEATURE_PDF_INVOICE` | ✅ |

---

## ❓ Troubleshooting

**Q: Fitur tidak tersembunyi setelah edit `.env`?**
A: Jalankan:
```bash
php artisan config:clear
php artisan view:clear
```
Refresh browser dengan `Ctrl + F5`

**Q: Script toggle-features.bat tidak jalan?**
A: Pastikan file `.env.to-usk` dan `.env.full` sudah ada. Edit `APP_KEY` di kedua file tersebut dengan key dari `.env` asli Anda.

**Q: Mau lihat fitur mana yang aktif sekarang?**
A: Check file `.env` Anda dan lihat value `FEATURE_*=true/false`

---

## 🎉 Done!

Sekarang Anda bisa **toggle fitur ON/OFF** hanya dengan 1 klik! 

Untuk TO USK: Hide semua → Fokus ke CRUD & Core Features ✅  
After TO USK: Show semua → Showcase Challenge Features 🚀

**Good luck untuk TO USK! 🎓**
