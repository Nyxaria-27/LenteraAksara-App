<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'title' => 'Filosofi Teras',
                'author' => 'Henry Manampiring',
                'description' => 'A modern interpretation of Stoic philosophy applied to daily life.',
                'price' => 80000,
                'stock' => 50,
                'isbn' => '9786024815705',
            ],
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'description' => 'An easy and proven way to build good habits and break bad ones.',
                'price' => 120000,
                'stock' => 40,
                'isbn' => '9780735211292',
            ],
            [
                'title' => 'Thinking, Fast and Slow',
                'author' => 'Daniel Kahneman',
                'description' => 'A groundbreaking tour of the mind and how we make decisions.',
                'price' => 150000,
                'stock' => 35,
                'isbn' => '9780374533557',
            ],
            [
                'title' => 'Sapiens: A Brief History of Humankind',
                'author' => 'Yuval Noah Harari',
                'description' => 'An exploration of human history from the Stone Age to the modern age.',
                'price' => 180000,
                'stock' => 30,
                'isbn' => '9780062316097',
            ],
            [
                'title' => 'Educated',
                'author' => 'Tara Westover',
                'description' => 'A memoir about a woman who grew up in a strict and abusive household in rural Idaho but eventually escaped to learn about the wider world through education.',
                'price' => 130000,
                'stock' => 25,
                'isbn' => '9780399590504',
            ],
            [
                'title' => 'The Subtle Art of Not Giving a F*ck',
                'author' => 'Mark Manson',
                'description' => 'A counterintuitive approach to living a good life.',
                'price' => 100000,
                'stock' => 45,
                'isbn' => '9780062457714',
            ],
            [
                'title' => 'Rich Dad Poor Dad',
                'author' => 'Robert T. Kiyosaki',
                'description' => 'What the rich teach their kids about money that the poor and middle class do not.',
                'price' => 95000,
                'stock' => 60,
                'isbn' => '9781612680194',
            ],
            [
                'title' => 'The Psychology of Money',
                'author' => 'Morgan Housel',
                'description' => 'Timeless lessons on wealth, greed, and happiness.',
                'price' => 110000,
                'stock' => 55,
                'isbn' => '9780857197689',
            ],
            [
                'title' => 'Ikigai: The Japanese Secret to a Long and Happy Life',
                'author' => 'Héctor García & Francesc Miralles',
                'description' => 'Discover the Japanese concept of Ikigai and how it can lead to a long, meaningful life.',
                'price' => 140000,
                'stock' => 20,
                'isbn' => '9781786330895',
            ],
            [
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'description' => 'A classic novel of racism and injustice in the deep South of the United States.',
                'price' => 165000,
                'stock' => 15,
                'isbn' => '9780061120084',
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
