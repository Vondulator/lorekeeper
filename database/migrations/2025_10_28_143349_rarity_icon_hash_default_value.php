<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        // Defaults are included in the original icon migration for fresh installs.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        // No schema change is performed by this compatibility migration.
    }
};
