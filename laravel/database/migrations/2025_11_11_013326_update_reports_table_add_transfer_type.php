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
        Schema::table('reports', function (Blueprint $table) {
            // Update type to include 'transfer'
            // The type column already exists, we just need to ensure it can accept 'transfer'
            // We'll also add fields for transfer tracking
            $table->foreignId('from_station_id')->nullable()->after('item_id')->constrained('stations')->onDelete('set null');
            $table->foreignId('to_station_id')->nullable()->after('from_station_id')->constrained('stations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropForeign(['from_station_id']);
            $table->dropForeign(['to_station_id']);
            $table->dropColumn(['from_station_id', 'to_station_id']);
        });
    }
};
