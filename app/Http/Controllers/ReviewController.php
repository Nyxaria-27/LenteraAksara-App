<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Admin: View all reviews
    public function adminIndex(Request $request)
    {
        $query = Review::with(['user', 'book'])->latest();

        // Filter by book
        if ($request->filled('book_id')) {
            $query->where('book_id', $request->book_id);
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Search by user name or comment
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhere('comment', 'like', "%{$search}%");
            });
        }

        $reviews = $query->paginate(20);
        $books = Book::orderBy('title')->get(['id', 'title']);

        return view('admin.reviews.index', compact('reviews', 'books'));
    }

    // Store new review
    public function store(Request $request, $bookId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Rating wajib dipilih',
            'rating.min' => 'Rating minimal 1 bintang',
            'rating.max' => 'Rating maksimal 5 bintang',
            'comment.max' => 'Komentar maksimal 1000 karakter',
        ]);

        // Check if book exists
        $book = Book::findOrFail($bookId);

        // Check if user has purchased this book with completed order
        if (!Auth::user()->hasPurchasedBook($bookId)) {
            return redirect()->back()->with('error', 'Anda hanya dapat memberikan ulasan untuk buku yang sudah Anda beli dan pesanan telah selesai (completed).');
        }

        // Check if user already reviewed this book
        $existingReview = Review::where('user_id', Auth::id())
            ->where('book_id', $bookId)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk buku ini.');
        }

        // Create review
        Review::create([
            'user_id' => Auth::id(),
            'book_id' => $bookId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Ulasan Anda berhasil ditambahkan.');
    }

    // Update existing review
    public function update(Request $request, $reviewId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Rating wajib dipilih',
            'rating.min' => 'Rating minimal 1 bintang',
            'rating.max' => 'Rating maksimal 5 bintang',
            'comment.max' => 'Komentar maksimal 1000 karakter',
        ]);

        $review = Review::findOrFail($reviewId);

        // Check if user owns this review
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Ulasan Anda berhasil diperbarui.');
    }

    // Delete review
    public function destroy($reviewId)
    {
        $review = Review::findOrFail($reviewId);

        // Check if user owns this review or is admin
        if ($review->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $review->delete();

        return redirect()->back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
