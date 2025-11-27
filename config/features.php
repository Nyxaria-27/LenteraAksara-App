<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Feature Flags
    |--------------------------------------------------------------------------
    |
    | Toggle fitur-fitur aplikasi untuk keperluan presentasi atau demo.
    | Set false untuk menyembunyikan fitur yang belum siap dipresentasikan.
    |
    */

    // === CHALLENGE FEATURES (Dapat di-hide untuk TO USK) ===
    
    'translation' => env('FEATURE_TRANSLATION', true), // Sistem bilingual ID/EN
    
    'dark_mode' => env('FEATURE_DARK_MODE', true), // Toggle dark mode
    
    'reviews' => env('FEATURE_REVIEWS', true), // Rating & Review buku
    
    'wishlist' => env('FEATURE_WISHLIST', true), // Wishlist/Favorit buku
    
    'cart' => env('FEATURE_CART', true), // Shopping cart & checkout
    
    'orders' => env('FEATURE_ORDERS', true), // Order history & management
    
    'search' => env('FEATURE_SEARCH', true), // Search & filter buku
    
    'contact' => env('FEATURE_CONTACT', true), // Contact form dengan notifikasi
    
    'notifications' => env('FEATURE_NOTIFICATIONS', true), // Sistem notifikasi real-time
    
    'aos_animations' => env('FEATURE_AOS_ANIMATIONS', true), // AOS scroll animations
    
    'pdf_invoice' => env('FEATURE_PDF_INVOICE', true), // Generate PDF invoice
    
    // === CORE FEATURES (Selalu tampil) ===
    
    'books_catalog' => true, // CRUD Buku (tidak bisa dimatikan)
    
    'categories' => true, // CRUD Kategori (tidak bisa dimatikan)
    
    'about_page' => true, // Halaman About Us (tidak bisa dimatikan)
    
    'authentication' => true, // Login/Register (tidak bisa dimatikan)
];
