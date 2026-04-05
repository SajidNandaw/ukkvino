<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id();

            // SAMAKAN TIPE DENGAN users.id & produk.id
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('produk_id');

            $table->unsignedTinyInteger('rating');
            $table->text('komentar')->nullable();

            $table->timestamps();

            // FOREIGN KEY MANUAL (LEBIH AMAN)
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('produk_id')
                  ->references('id')
                  ->on('produk')
                  ->onDelete('cascade');

            $table->unique(['user_id','produk_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};