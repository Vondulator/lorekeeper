<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRepeatToPrompts extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::table('prompts', function (Blueprint $table) {
            $table->text('prompt_timeframe')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() {
        Schema::table('prompts', function (Blueprint $table) {
            $table->dropColumn('prompt_timeframe');
        });
    }
}
