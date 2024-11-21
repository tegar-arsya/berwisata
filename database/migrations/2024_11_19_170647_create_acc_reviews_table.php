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
        Schema::create('acc_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('review_id');  // Mengacu ke ulasan yang ada di tabel reviews
    $table->boolean('status')->default(false);
            $table->timestamps();

            $table->foreign('review_id')->references('id')->on('reviews')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_reviews');
    }
};
