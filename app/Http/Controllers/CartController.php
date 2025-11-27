<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NavbarHelper;

class CartController extends Controller
{
    // Tampilkan isi cart user
    public function index()
    {
        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
        ]);

        $items = $cart->items()->with('book')->get();

        return view('user.cart.index', compact('cart', 'items'));
    }

    // Tambah buku ke cart
    public function store(Request $request, $bookId)
    {
        $book = Book::findOrFail($bookId);

        // Validasi jumlah yang diminta
        $quantity = $request->input('quantity', 1);

        if ($quantity > $book->stock) {
            return back()->with('error', 'Jumlah melebihi stok tersedia!');
        }

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        $cartItem = $cart->items()->where('book_id', $book->id)->first();

        if ($cartItem) {
            $newQty = $cartItem->quantity + $quantity;
            if ($newQty > $book->stock) {
                return back()->with('error', 'Jumlah total di cart melebihi stok!');
            }
            $cartItem->update(['quantity' => $newQty]);
        } else {
            $cart->items()->create([
                'book_id' => $book->id,
                'quantity' => $quantity,
            ]);
        }

        // Clear navbar cache
        NavbarHelper::clearCache();

        return back()->with('success', 'Buku ditambahkan ke cart!');
    }


    // Update jumlah item di cart
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::whereHas('cart', function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($itemId);

        $book = $cartItem->book;

        if ($request->quantity > $book->stock) {
            return back()->with('error', 'Quantity exceeds available stock!');
        }

        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        // Clear navbar cache
        NavbarHelper::clearCache();

        return back()->with('success', 'Cart updated!');
    }


    // Hapus item dari cart
    public function destroy($itemId)
    {
        $cartItem = CartItem::whereHas('cart', function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($itemId);

        $cartItem->delete();

        // Clear navbar cache
        NavbarHelper::clearCache();

        return redirect()->back()->with('success', 'Item removed from cart!');
    }
}
