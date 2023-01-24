<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeRatingColumnOnEligibilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::statement("ALTER TABLE `eligibilities` CHANGE COLUMN `rating` `rating` DOUBLE(5,2) NULL AFTER `type`;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `eligibilities` CHANGE COLUMN `rating` `rating` DOUBLE(5,2) NOT NULL AFTER `type`;");
    }
}
