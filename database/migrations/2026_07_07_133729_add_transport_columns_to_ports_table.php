<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ports', function (Blueprint $table) {

            $table->integer('delay_hours')
                  ->default(0)
                  ->after('status');

            $table->integer('capacity')
                  ->default(100)
                  ->after('delay_hours');

            $table->string('congestion')
                  ->default('Low')
                  ->after('capacity');

            $table->integer('transport_risk')
                  ->default(0)
                  ->after('congestion');

        });
    }

    public function down(): void
    {
        Schema::table('ports', function (Blueprint $table) {

            $table->dropColumn([

                'delay_hours',

                'capacity',

                'congestion',

                'transport_risk'

            ]);

        });
    }
};