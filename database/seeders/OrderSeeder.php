<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Book;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get test user (non-admin)
        $user = User::where('role', 'user')->first();
        
        if (!$user) {
            $this->command->warn('No user found. Please run UserSeeder first.');
            return;
        }

        // Get some books
        $books = Book::take(5)->get();
        
        if ($books->isEmpty()) {
            $this->command->warn('No books found. Please run BookSeeder first.');
            return;
        }

        // Create sample orders with different statuses
        $statuses = ['pending', 'processing', 'shipped', 'completed'];
        $addresses = [
            'Jl. Merdeka No. 123, RT 01/RW 05, Kelurahan Menteng, Kecamatan Menteng, Jakarta Pusat, DKI Jakarta 10310',
            'Jl. Sudirman No. 456, RT 03/RW 07, Kelurahan Kebayoran Baru, Kecamatan Kebayoran Baru, Jakarta Selatan 12180',
            'Jl. Asia Afrika No. 789, RT 02/RW 04, Kelurahan Braga, Kecamatan Sumur Bandung, Bandung, Jawa Barat 40111'
        ];

        foreach ($statuses as $index => $status) {
            $order = Order::create([
                'user_id' => $user->id,
                'status' => $status,
                'address' => $addresses[$index % count($addresses)],
                'payment_method' => 'COD',
                'total_price' => 0,
                'shipping_notes' => $status === 'shipped' ? 'Paket dikirim via JNE dengan nomor resi JNE' . rand(1000000000, 9999999999) : ($status === 'completed' ? 'Paket telah diterima oleh penerima' : null),
            ]);

            $totalPrice = 0;
            
            // Add 2-3 random books to each order
            $orderBooks = $books->random(rand(2, 3));
            
            foreach ($orderBooks as $book) {
                $quantity = rand(1, 3);
                $price = $book->price;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $book->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);
                
                $totalPrice += $price * $quantity;
            }

            $order->update(['total_price' => $totalPrice]);
        }

        $this->command->info('Sample orders created successfully!');
    }
}
