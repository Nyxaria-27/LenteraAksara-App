<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\User;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get user with ID 2 (regular user from UserSeeder)
        $user = User::where('role', 'user')->first();

        if ($user) {
            // Sample contact 1 - Open (belum dibalas)
            Contact::create([
                'user_id' => $user->id,
                'subject' => 'Pertanyaan tentang Pengiriman',
                'message' => 'Halo admin, saya ingin menanyakan tentang estimasi waktu pengiriman untuk wilayah Bandung. Apakah ada biaya tambahan untuk pengiriman ke luar kota?',
                'status' => 'open',
                'admin_seen' => false,
                'user_seen' => true,
            ]);

            echo "Sample contacts created successfully!\n";
        }
    }
}
