<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Philosophy',
            'Psychology',
            'Self-Help',
            'Business',
            'Technology',
            'Science',
            'History',
            'Fiction',
            'Fantasy',
            'Education'
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
