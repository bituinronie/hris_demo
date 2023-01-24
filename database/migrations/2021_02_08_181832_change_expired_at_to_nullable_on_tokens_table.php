<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeExpiredAtToNullableOnTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        DB::statement('ALTER TABLE `tokens` CHANGE COLUMN 
                            `expired_at` `expired_at` TIMESTAMP NULL DEFAULT 
                            CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER `model_name`;');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `tokens` CHANGE COLUMN
                            `expired_at` `expired_at` TIMESTAMP NOT NULL DEFAULT 
                            CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER `model_name`;');
    }
}
