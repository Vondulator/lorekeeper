<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEncounterCharacters extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::table('user_settings', function (Blueprint $table) {
            $table->integer('encounter_character_id')->nullable()->default(null);
        });

        Schema::table('characters', function (Blueprint $table) {
            $table->integer('encounter_energy')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() {
        Schema::table('user_settings', function (Blueprint $table) {
            $table->dropColumn('encounter_character_id');
        });
        Schema::table('characters', function (Blueprint $table) {
            $table->dropColumn('encounter_energy');
        });
    }
}
