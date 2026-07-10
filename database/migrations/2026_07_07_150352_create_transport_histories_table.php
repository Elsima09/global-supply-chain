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
    Schema::create('transport_histories', function (Blueprint $table) {

        $table->id();

        $table->foreignId('port_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->integer('risk_score');

        $table->integer('delay_hours');

        $table->integer('capacity');

        $table->string('congestion');

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport_histories');
    }
};
