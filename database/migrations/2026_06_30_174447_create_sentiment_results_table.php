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
    Schema::create('sentiment_results', function (Blueprint $table) {
        $table->id();
        $table->foreignId('news_cache_id')->constrained('news_cache')->onDelete('cascade');
        $table->integer('positive_score')->default(0);
        $table->integer('negative_score')->default(0);
        $table->string('sentiment');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sentiment_results');
    }
};
