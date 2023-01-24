<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeColumnOnSpecialDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('special_dates', function (Blueprint $table) {
            DB::statement("ALTER TABLE `special_dates`
            CHANGE COLUMN `type` `type` ENUM('SPECIAL','LEGAL','SUSPENSION','FLAG_CEREMONY','CALAMITY') NOT NULL COLLATE 'utf8mb4_unicode_ci' AFTER `reference_time`;");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('special_dates', function (Blueprint $table) {
            DB::statement("ALTER TABLE `special_dates`
            CHANGE COLUMN `type` `type` ENUM('SPECIAL','LEGAL','SUSPENSION','FLAG_CEREMONY') NOT NULL COLLATE 'utf8mb4_unicode_ci' AFTER `reference_time`;");
        });
    }
}
