<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content')->nullable(); // simpan HTML/Markdown yang diedit admin
            $table->string(column: 'image')->nullable();
            $table->timestamps();
        });

        // Insert default row supaya selalu ada
        DB::table('abouts')->insert([
            'title' => 'Tentang Kami: Lentera Aksara',
            'content' => '<div style="line-height: 1.8; color: #333;">
    <h2 style="color: #4B5320;">Tentang Kami: Lentera Aksara</h2>
    <p>Selamat datang di <strong>Lentera Aksara</strong>, sebuah ruang yang didirikan atas dasar kecintaan yang mendalam terhadap dunia literasi dan kekuatan narasi.</p>
    <p>Kami percaya bahwa setiap buku adalah sebuah lentera yang mampu menerangi lorong-lorong pikiran, menawarkan panduan, inspirasi, dan koneksi ke dunia yang tak terbatas.</p>
</div>',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
