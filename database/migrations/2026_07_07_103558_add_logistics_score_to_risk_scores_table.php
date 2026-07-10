<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('risk_scores', function (Blueprint $table) {

            $table->integer('logistics_score')
                ->default(0);

        });
    }


    public function down(): void
    {
        Schema::table('risk_scores', function (Blueprint $table) {

            $table->dropColumn('logistics_score');

        });
    }

};