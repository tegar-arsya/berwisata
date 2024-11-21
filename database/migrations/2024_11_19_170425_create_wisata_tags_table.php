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
        Schema::create('wisata_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wisata_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();

            $table->foreign('wisata_id')->references('id')->on('wisatas')->onDelete('cascade');
    $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wisata_tags');
    }
};
