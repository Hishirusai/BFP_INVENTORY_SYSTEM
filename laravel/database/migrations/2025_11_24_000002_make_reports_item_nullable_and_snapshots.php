<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::getDriverName();

        // For SQLite we must recreate the table to change nullability/foreign key behavior
        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=OFF');

            DB::statement(<<<'SQL'
CREATE TABLE reports_new (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type TEXT NOT NULL,
    item_id INTEGER NULL,
    user_id INTEGER NOT NULL,
    quantity_change INTEGER NOT NULL,
    cost_change DECIMAL(10,2),
    reason TEXT,
    item_name TEXT,
    item_sku TEXT,
    from_station_id INTEGER,
    to_station_id INTEGER,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY(item_id) REFERENCES items(id) ON DELETE SET NULL,
    FOREIGN KEY(from_station_id) REFERENCES stations(id) ON DELETE SET NULL,
    FOREIGN KEY(to_station_id) REFERENCES stations(id) ON DELETE SET NULL
);
SQL
            );

            // Copy existing data (if item_name/item_sku exist in source, they'll be copied)
            DB::statement(<<<'SQL'
INSERT INTO reports_new (id, type, item_id, user_id, quantity_change, cost_change, reason, item_name, item_sku, from_station_id, to_station_id, created_at, updated_at)
SELECT id, type, item_id, user_id, quantity_change, cost_change, reason,
       CASE WHEN (SELECT COUNT(*) FROM pragma_table_info('reports') WHERE name='item_name')>0 THEN item_name ELSE NULL END,
       CASE WHEN (SELECT COUNT(*) FROM pragma_table_info('reports') WHERE name='item_sku')>0 THEN item_sku ELSE NULL END,
       CASE WHEN (SELECT COUNT(*) FROM pragma_table_info('reports') WHERE name='from_station_id')>0 THEN from_station_id ELSE NULL END,
       CASE WHEN (SELECT COUNT(*) FROM pragma_table_info('reports') WHERE name='to_station_id')>0 THEN to_station_id ELSE NULL END,
       created_at, updated_at
FROM reports;
SQL
            );

            DB::statement('DROP TABLE reports');
            DB::statement('ALTER TABLE reports_new RENAME TO reports');
            DB::statement('PRAGMA foreign_keys=ON');
        } else {
            // For other DBs, attempt a simple migration (may require doctrine/dbal)
            Schema::table('reports', function ($table) {
                if (! Schema::hasColumn('reports', 'item_name')) {
                    $table->string('item_name')->nullable()->after('reason');
                }
                if (! Schema::hasColumn('reports', 'item_sku')) {
                    $table->string('item_sku')->nullable()->after('item_name');
                }
            });

            try {
                Schema::table('reports', function ($table) {
                    $table->unsignedBigInteger('item_id')->nullable()->change();
                });
                Schema::table('reports', function ($table) {
                    $table->dropForeign(['item_id']);
                    $table->foreign('item_id')->references('id')->on('items')->onDelete('set null');
                });
            } catch (\Exception $e) {
                // If change() isn't supported, log or instruct user to install doctrine/dbal
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reversing this migration is non-trivial for SQLite; we'll leave a best-effort rollback.
        $driver = DB::getDriverName();
        if ($driver === 'sqlite') {
            // Attempt to recreate original table with item_id NOT NULL and cascade delete
            DB::statement('PRAGMA foreign_keys=OFF');
            DB::statement(<<<'SQL'
CREATE TABLE reports_old (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type TEXT NOT NULL,
    item_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    quantity_change INTEGER NOT NULL,
    cost_change DECIMAL(10,2),
    reason TEXT,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY(item_id) REFERENCES items(id) ON DELETE CASCADE,
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
);
SQL
            );
            DB::statement('INSERT INTO reports_old (id, type, item_id, user_id, quantity_change, cost_change, reason, created_at, updated_at) SELECT id, type, COALESCE(item_id, 0), user_id, quantity_change, cost_change, reason, created_at, updated_at FROM reports');
            DB::statement('DROP TABLE reports');
            DB::statement('ALTER TABLE reports_old RENAME TO reports');
            DB::statement('PRAGMA foreign_keys=ON');
        } else {
            // Best-effort revert for non-sqlite: change item_id back to not nullable and fk cascade
            try {
                Schema::table('reports', function ($table) {
                    $table->dropForeign(['item_id']);
                });
                Schema::table('reports', function ($table) {
                    $table->unsignedBigInteger('item_id')->nullable(false)->change();
                    $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
                });
            } catch (\Exception $e) {
            }
        }
    }
};
