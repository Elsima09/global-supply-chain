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
    Schema::table('risk_scores', function (Blueprint $table) {

        $table->integer('economic_score')
              ->default(0)
              ->after('weather_score');

    });
}

public function down()
{
    Schema::table('risk_scores', function (Blueprint $table) {

        $table->dropColumn('economic_score');

    });
}
};
