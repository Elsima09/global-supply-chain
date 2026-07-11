<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        if (!Schema::hasColumn('economic_data', 'year')) {

            Schema::table('economic_data', function (Blueprint $table) {

                $table->integer('year')
                    ->default(2025)
                    ->after('country_id');

            });

        }
    }


    public function down(): void
    {

        if (Schema::hasColumn('economic_data', 'year')) {

            Schema::table('economic_data', function (Blueprint $table) {

                $table->dropColumn('year');

            });

        }

    }

};