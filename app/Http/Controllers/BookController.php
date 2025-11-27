<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function show($id)
    {
        $book = Book::with('categories')->findOrFail($id);

        // Load reviews with user info, paginated
        $reviews = $book->reviews()
            ->with('user')
            ->latest()
            ->paginate(5);

        // Get average rating
        $averageRating = round($book->averageRating(), 1);
        $reviewsCount = $book->reviewsCount();

        // Check if current user has reviewed this book
        $userReview = null;
        $canReview = false;
        
        if (auth()->check()) {
            $userReview = $book->reviews()
                ->where('user_id', auth()->id())
                ->first();
            
            // User can review if they have purchased this book with completed order
            $canReview = auth()->user()->hasPurchasedBook($id);
        }

        $relatedBooks = Book::whereHas('categories', function ($q) use ($book) {
            $q->whereIn('id', $book->categories->pluck('id'));
        })
            ->where('id', '!=', $book->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('user.books.show', compact('book', 'relatedBooks', 'reviews', 'averageRating', 'reviewsCount', 'userReview', 'canReview'));
    }


    public function index(Request $request)
    {
        $query = Book::with('categories');
        $categories = Category::all();
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('author', 'like', '%' . $request->search . '%')
                    ->orWhere('isbn', 'like', '%' . $request->search . '%');
            });
        }

        $books = $query->latest()->paginate(10);
        return view('books.index', compact('books', 'categories'));
    }

    public function adminIndex(Request $request)
    {
        $query = Book::with('categories');
        $categories = Category::all();

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('author', 'like', '%' . $request->search . '%')
                    ->orWhere('isbn', 'like', '%' . $request->search . '%');
            });
        }


        $books = $query->latest()->paginate(10);
        return view('admin.books.index', compact('books', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {

        // store
        $validated = $request->validate([
            'title' => 'required',
            'author' => 'required',
            'isbn' => 'required|unique:books,isbn',
            'price' => 'required|integer|min:10000',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable',
            'categories' => 'array|required',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
            $validated['cover'] = $coverPath;
        }

        $book = Book::create($validated);
        $book->categories()->sync($validated['categories']);


        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $categories = Category::all();
        $book = Book::find($id);
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'isbn' => 'required|unique:books,isbn,' . $id,
            'price' => 'required|integer|min:10000',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable',
            'categories' => 'array|required',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $book = Book::findOrFail($id);

        $data = $request->only(['title', 'author', 'isbn', 'price', 'stock', 'description']);

        // Handle Cover Upload
        if ($request->hasFile('cover')) {
            // Hapus cover lama
            if ($book->cover && Storage::disk('public')->exists($book->cover)) {
                Storage::disk('public')->delete($book->cover);
            }

            // Simpan cover baru
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        // Update data buku
        $book->update($data);

        // Update categories
        $book->categories()->sync($request->categories);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diupdate.');
    }

    // destroy
    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        if ($book->stock > 0) {
            return redirect()->route('admin.books.index')
                ->with('error', 'Buku tidak bisa dihapus karena stok masih tersedia.');
        }

        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Buku dihapus.');
    }
}
