<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

public function up(): void
{

Schema::table('ports', function (Blueprint $table) {


    if (!Schema::hasColumn('ports','delay_hours')) {

        $table->integer('delay_hours')
            ->default(0);

    }


    if (!Schema::hasColumn('ports','capacity')) {

        $table->integer('capacity')
            ->default(100);

    }


    if (!Schema::hasColumn('ports','congestion')) {

        $table->string('congestion')
            ->default('Low');

    }


    if (!Schema::hasColumn('ports','transport_risk')) {

        $table->integer('transport_risk')
            ->default(20);

    }


});


}



public function down(): void
{

Schema::table('ports', function(Blueprint $table){

    $table->dropColumn([

        'delay_hours',
        'capacity',
        'congestion',
        'transport_risk'

    ]);

});

}

};