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
    Schema::table('countries', function (Blueprint $table) {
        $table->bigInteger('export_value')->nullable()->after('gdp');
        $table->bigInteger('import_value')->nullable()->after('export_value');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('countries', function (Blueprint $table) {
        $table->dropColumn(['export_value', 'import_value']);
    });
}
};
