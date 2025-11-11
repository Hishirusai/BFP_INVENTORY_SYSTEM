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
        Schema::table('items', function (Blueprint $table) {
            $table->foreignId('station_id')->nullable()->after('supplier_id')->constrained()->onDelete('set null');
            $table->string('condition')->default('serviceable')->after('status'); // 'serviceable' or 'unserviceable'
            $table->integer('life_span_years')->nullable()->after('condition'); // Life span in years
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['station_id']);
            $table->dropColumn(['station_id', 'condition', 'life_span_years']);
        });
    }
};
