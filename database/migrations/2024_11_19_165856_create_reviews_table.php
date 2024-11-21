<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wisata_id');
            $table->string('nama_pengunjung');  // Nama pengunjung tanpa login
            $table->integer('rating')->default(0);  // Skor rating (1-5)
            $table->text('komentar');
            $table->timestamps();

            $table->foreign('wisata_id')->references('id')->on('wisatas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
