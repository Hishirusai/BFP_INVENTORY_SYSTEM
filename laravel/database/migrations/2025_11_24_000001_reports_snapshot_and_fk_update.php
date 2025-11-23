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
        // NOTE: This migration alters the reports table to:
        // - add snapshot columns (`item_name`, `item_sku`)
        // Changing existing foreign keys or modifying column nullability may require
        // `doctrine/dbal` on some DB drivers (SQLite does not support altering columns).
        // To avoid requiring extra dependencies, this migration only adds snapshot columns.
        Schema::table('reports', function (Blueprint $table) {
            if (!Schema::hasColumn('reports', 'item_name')) {
                $table->string('item_name')->nullable();
            }
            if (!Schema::hasColumn('reports', 'item_sku')) {
                $table->string('item_sku')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            if (Schema::hasColumn('reports', 'item_sku')) {
                $table->dropColumn('item_sku');
            }
            if (Schema::hasColumn('reports', 'item_name')) {
                $table->dropColumn('item_name');
            }
        });
    }
};
