<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

public function up(): void
{

Schema::table('ports', function(Blueprint $table){

    $table->dropColumn('country');


    $table->foreignId('country_id')
        ->after('id')
        ->constrained()
        ->cascadeOnDelete();


    $table->integer('delay_hours')
        ->default(0);

    $table->integer('capacity')
        ->default(100);

    $table->string('congestion')
        ->default('Low');

    $table->integer('transport_risk')
        ->default(20);


});


}



public function down(): void
{

Schema::table('ports', function(Blueprint $table){

    $table->dropForeign(['country_id']);

    $table->dropColumn([
        'country_id',
        'delay_hours',
        'capacity',
        'congestion',
        'transport_risk'
    ]);


    $table->string('country');

});


}

};