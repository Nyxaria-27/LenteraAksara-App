<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name'
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_categories');
    }
}
