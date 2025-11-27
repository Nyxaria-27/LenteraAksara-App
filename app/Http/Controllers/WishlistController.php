<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Helpers\NavbarHelper;

class WishlistController extends Controller
{
    // Toggle wishlist (add or remove)
    public function toggle($bookId)
    {
        $user = auth()->user();
        
        // Check if book exists
        $book = Book::findOrFail($bookId);
        
        // Check if already in wishlist
        $existingWishlist = Wishlist::where('user_id', $user->id)
            ->where('book_id', $bookId)
            ->first();
        
        if ($existingWishlist) {
            // Remove from wishlist
            $existingWishlist->delete();
            
            // Clear navbar cache
            NavbarHelper::clearCache();
            
            return back()->with('success', 'Buku berhasil dihapus dari wishlist!');
        } else {
            // Add to wishlist
            Wishlist::create([
                'user_id' => $user->id,
                'book_id' => $bookId,
            ]);
            
            // Clear navbar cache
            NavbarHelper::clearCache();
            
            return back()->with('success', 'Buku berhasil ditambahkan ke wishlist!');
        }
    }

    // Show user's wishlist
    public function index()
    {
        $wishlists = auth()->user()->wishlists()->with('book')->latest()->paginate(12);
        return view('user.wishlist.index', compact('wishlists'));
    }

    // Remove from wishlist
    public function destroy($id)
    {
        $wishlist = Wishlist::findOrFail($id);
        
        // Check ownership
        if ($wishlist->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $wishlist->delete();
        
        // Clear navbar cache
        NavbarHelper::clearCache();
        
        return back()->with('success', 'Buku berhasil dihapus dari wishlist!');
    }
}
