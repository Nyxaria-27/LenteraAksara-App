<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $books = Book::all();

        if ($users->isEmpty() || $books->isEmpty()) {
            $this->command->warn('No users or books found. Skipping review seeder.');
            return;
        }

        $comments = [
            'Buku yang sangat menginspirasi! Sangat direkomendasikan untuk dibaca.',
            'Ceritanya menarik dan penuh dengan pesan moral yang mendalam.',
            'Salah satu buku terbaik yang pernah saya baca. Worth it!',
            'Bahasa yang digunakan mudah dipahami, sangat cocok untuk pemula.',
            'Plot twist yang tidak terduga! Sangat seru dari awal hingga akhir.',
            'Buku ini memberikan perspektif baru tentang kehidupan.',
            'Karakternya sangat relatable, saya merasa terhubung dengan ceritanya.',
            'Agak lambat di awal, tapi semakin seru di pertengahan.',
            'Ending-nya kurang memuaskan, tapi overall masih bagus.',
            'Buku yang wajib dibaca oleh semua orang!',
            'Penulisannya sangat detail dan deskriptif.',
            'Tidak sesuai ekspektasi saya, tapi tetap readable.',
            'Buku yang sangat edukatif dan informatif.',
            'Ceritanya biasa saja, tidak terlalu memorable.',
            'Masterpiece! Tidak ada kata lain yang bisa mendeskripsikan buku ini.',
        ];

        $reviewsCreated = 0;

        // Create 20-30 random reviews
        for ($i = 0; $i < rand(20, 30); $i++) {
            $user = $users->random();
            $book = $books->random();

            // Check if this user already reviewed this book
            $existing = Review::where('user_id', $user->id)
                ->where('book_id', $book->id)
                ->first();

            if (!$existing) {
                Review::create([
                    'user_id' => $user->id,
                    'book_id' => $book->id,
                    'rating' => rand(3, 5), // Mostly positive reviews
                    'comment' => $comments[array_rand($comments)],
                ]);
                $reviewsCreated++;
            }
        }

        $this->command->info("Created {$reviewsCreated} reviews successfully.");
    }
}
