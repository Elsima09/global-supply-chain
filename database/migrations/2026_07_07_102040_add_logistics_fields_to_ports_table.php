<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ports', function (Blueprint $table) {

            $table->string('traffic_level')
                ->default('Medium');

            $table->integer('congestion_level')
                ->default(30);

            $table->integer('logistics_score')
                ->default(30);

        });
    }


    public function down(): void
    {
        Schema::table('ports', function (Blueprint $table) {

            $table->dropColumn([
                'traffic_level',
                'congestion_level',
                'logistics_score'
            ]);

        });
    }
};