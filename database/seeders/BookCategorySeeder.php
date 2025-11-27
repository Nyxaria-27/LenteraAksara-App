<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class BookCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Attach books to categories
        // Assuming you already have categories: Philosophy, Psychology, History, Finance, Self-Help, Literature

        $bookCategories = [
            'Filosofi Teras' => ['Philosophy', 'Self-Help'],
            'Atomic Habits' => ['Self-Help', 'Psychology'],
            'Thinking, Fast and Slow' => ['Psychology', 'Philosophy'],
            'Sapiens: A Brief History of Humankind' => ['History', 'Philosophy'],
            'Educated' => ['Biography', 'Literature'],
            'The Subtle Art of Not Giving a F*ck' => ['Self-Help'],
            'Rich Dad Poor Dad' => ['Finance', 'Self-Help'],
            'The Psychology of Money' => ['Finance', 'Psychology'],
            'Ikigai: The Japanese Secret to a Long and Happy Life' => ['Philosophy', 'Self-Help'],
            'To Kill a Mockingbird' => ['Literature', 'History'],
        ];

        foreach ($bookCategories as $bookTitle => $categories) {
            $book = Book::where('title', $bookTitle)->first();
            if ($book) {
                $categoryIds = Category::whereIn('name', $categories)->pluck('id');
                $book->categories()->attach($categoryIds);
            }
        }
    }
}
