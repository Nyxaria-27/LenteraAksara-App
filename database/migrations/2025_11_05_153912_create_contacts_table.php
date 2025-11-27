<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('subject')->nullable();
            $table->text('message');       // pesan dari user
            $table->text('admin_reply')->nullable(); // balasan admin
            $table->enum('status', ['open', 'closed', 'replied'])->default('open');
            $table->boolean('admin_seen')->default(false);  // admin sudah baca?
            $table->boolean('user_seen')->default(false);   // user sudah baca balasan?
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
