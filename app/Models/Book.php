<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'price',
        'stock',
        'description',
        'cover',
    ];

    // Many-to-Many
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'book_categories');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // One-to-Many: Book has many reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // One-to-Many: Book has many wishlists
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    // Helper: Get average rating
    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    // Helper: Get total reviews count
    public function reviewsCount()
    {
        return $this->reviews()->count();
    }

    
}
