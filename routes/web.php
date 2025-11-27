<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LanguageController;

// Public route
Route::get('/', [UserController::class, 'welcome'])->name('welcome');
Route::view('/terms', 'terms')->name('terms');
Route::view('/privacy', 'privacy')->name('privacy');

// Language switcher
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // User routes
    Route::middleware([CheckRole::class . ':user'])->group(function () {
        Route::get('/user/dashboard', [UserController::class, 'index'])->name('books.index');
        Route::get('/books/search', [UserController::class, 'index'])->name('books.search');
        Route::get('/books/suggest', [UserController::class, 'suggestBooks'])->name('books.suggest'); // AJAX endpoint
        Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
        
        // Cart routes
        Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/{bookId}', [\App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
        Route::put('/cart/{itemId}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{itemId}', [\App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');
        
        // Checkout routes
        Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
        Route::post('/checkout/buy-now/{bookId}', [\App\Http\Controllers\CheckoutController::class, 'buyNow'])->name('checkout.buyNow');
        
        // User Orders routes
        Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('user.orders.index');
        Route::get('/orders/{id}', [\App\Http\Controllers\OrderController::class, 'show'])->name('user.orders.show');
        
        // User Contact routes
        Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'index'])->name('user.contact.index');
        Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('user.contact.store');
        Route::post('/contact/{id}/mark-seen', [\App\Http\Controllers\ContactController::class, 'userMarkSeen'])->name('user.contact.markSeen');
        
        // Review routes
        Route::post('/books/{bookId}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
        Route::put('/reviews/{reviewId}', [\App\Http\Controllers\ReviewController::class, 'update'])->name('reviews.update');
        Route::delete('/reviews/{reviewId}', [\App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');
        
        // Wishlist routes
        Route::post('/wishlist/toggle/{bookId}', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
        Route::get('/wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
        Route::delete('/wishlist/{id}', [\App\Http\Controllers\WishlistController::class, 'destroy'])->name('wishlist.destroy');
        
        // Sorting handled via ?sort=terbaru|terlaris|termurah in /books
        // ...other user routes
    });

    // Admin routes
    Route::middleware([CheckRole::class . ':admin'])->group(function () {
        Route::get('/admin', [UserController::class, 'admin'])->name('admin.dashboard');
        Route::get('/admin/users', [UserController::class, 'adminIndex'])->name('admin.users.index');
        Route::get('/book', [UserController::class, 'adminIndex'])->name('admin.users.index');

        //CRUD Book
         Route::get('admin/books', [BookController::class, 'adminIndex'])->name('admin.books.index');
        Route::get('admin/books/create', [BookController::class, 'create'])->name('admin.books.create');
        Route::post('admin/books/', [BookController::class, 'store'])->name('admin.books.store');
        Route::get('admin/books/edit/{id}', [BookController::class, 'edit'])->name('admin.books.edit');
        Route::put('admin/books/{id}', [BookController::class, 'update'])->name('admin.books.update');
        Route::delete('admin/books/{id}', [BookController::class, 'destroy'])->name('admin.books.destroy');

        // Manage Reviews (Admin)
        Route::get('admin/reviews', [\App\Http\Controllers\ReviewController::class, 'adminIndex'])->name('admin.reviews.index');

        // CRUD Category
        Route::get('admin/categories', [\App\Http\Controllers\CategoryController::class, 'adminIndex'])->name('admin.categories.index');
        Route::post('admin/categories', [\App\Http\Controllers\CategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('admin/categories/{id}/edit', [\App\Http\Controllers\CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('admin/categories/{id}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('admin/categories/{id}', [\App\Http\Controllers\CategoryController::class, 'destroy'])->name('admin.categories.destroy');
       
        // Admin Orders Management
        Route::get('admin/orders', [\App\Http\Controllers\OrderController::class, 'adminIndex'])->name('admin.orders.index');
        Route::get('admin/orders/{id}', [\App\Http\Controllers\OrderController::class, 'adminShow'])->name('admin.orders.show');
        Route::put('admin/orders/{id}/status', [\App\Http\Controllers\OrderController::class, 'adminUpdateStatus'])->name('admin.orders.updateStatus');
        
        // Admin Contact Management
        Route::get('admin/contacts', [\App\Http\Controllers\ContactController::class, 'adminIndex'])->name('admin.contacts.index');
        Route::get('admin/contacts/{id}', [\App\Http\Controllers\ContactController::class, 'adminShow'])->name('admin.contacts.show');
        Route::post('admin/contacts/{id}/reply', [\App\Http\Controllers\ContactController::class, 'adminReply'])->name('admin.contacts.reply');
        Route::post('admin/contacts/{id}/mark-seen', [\App\Http\Controllers\ContactController::class, 'adminMarkSeen'])->name('admin.contacts.markSeen');
        
        // Admin About Management
        Route::get('admin/about/edit', [\App\Http\Controllers\AboutController::class, 'edit'])->name('admin.about.edit');
        Route::put('admin/about/update', [\App\Http\Controllers\AboutController::class, 'update'])->name('admin.about.update');
        
        // Report/Invoice
        Route::get('admin/reports/invoice/{orderId}', [\App\Http\Controllers\ReportController::class, 'generateInvoice'])->name('report.invoice');
        
        // ...other admin routes
    });


    // Profile routes (shared)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// Static pages
Route::get('/about', fn() => view('about'))->name('about');


require __DIR__.'/auth.php';
