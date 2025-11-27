<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\About;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    // AJAX endpoint for book auto-suggestion
    public function suggestBooks(Request $request)
    {
        $q = $request->input('q');
        if (!$q || strlen($q) < 2) {
            return response()->json([]);
        }
        $books = Book::where('title', 'like', "%$q%")
            ->orWhere('author', 'like', "%$q%")
            ->orWhere('isbn', 'like', "%$q%")
            ->limit(8)
            ->get(['id', 'title', 'author', 'isbn']);
        return response()->json($books);
    }
    public function welcome(Request $request)
    {
        $about = About::first();
        
        // Books preview dengan pagination (5 buku per halaman)
        $books = Book::with('categories')->latest()->paginate(5);

        return view('welcome', compact('about', 'books'));
    }

    public function index(Request $request)
    {
        $query = Book::query();

        // Filter by category
        if ($request->has('category') && $request->category != null) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        // Search by title / author / isbn
        if ($request->has('search') && $request->search != null) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('author', 'like', '%' . $search . '%')
                    ->orWhere('isbn', 'like', '%' . $search . '%');
            });
        }

        // Filter by rating
        if ($request->has('rating') && $request->rating != null) {
            $rating = (int) $request->rating;
            $query->whereHas('reviews', function ($q) use ($rating) {
                $q->selectRaw('book_id, AVG(rating) as avg_rating')
                    ->groupBy('book_id')
                    ->havingRaw('AVG(rating) >= ?', [$rating]);
            });
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'newest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'title_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'title_desc':
                    $query->orderBy('title', 'desc');
                    break;
                case 'terlaris':
                    // Sort by most sold (order_items count)
                    $query->withCount('orderItems')->orderBy('order_items_count', 'desc');
                    break;
                case 'termurah':
                    $query->orderBy('price', 'asc');
                    break;
                case 'rating_high':
                    // Sort by highest rating
                    $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');
                    break;
                case 'rating_low':
                    // Sort by lowest rating
                    $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'asc');
                    break;
            }
        }

        // Get data with pagination
        $books = $query->paginate(9)->withQueryString();

        // Ambil semua kategori untuk dropdown/filter
        $categories = Category::withCount('books')->get();

        // Get user's wishlist book IDs (if authenticated)
        $wishlistBookIds = [];
        if (auth()->check()) {
            $wishlistBookIds = auth()->user()->wishlists()->pluck('book_id')->toArray();
        }

        return view('user.dashboard', compact('books', 'categories', 'wishlistBookIds'));
    }

    
    public function admin()
    {
        return view('admin.dashboard', [
            'booksCount'      => Book::count(),
            'categoriesCount' => Category::count(),
            'usersCount'      => User::count(),
            'ordersCount'     => Order::count(),
            'latestBooks'     => Book::with('categories')->latest()->take(5)->get(),
            'categories'      => Category::withCount('books')->get(),
        ]);
    }

    public function adminIndex()
    {
        $users = User::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->paginate(15);
        return view('admin.users.index', compact('users'));
    }
}
