<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCivilStatusColumnOnEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `employees`
        CHANGE COLUMN `civil_status` `civil_status` ENUM('SINGLE','MARRIED','WIDOWED','SEPARATED','OTHERS') NOT NULL COLLATE 'utf8mb4_unicode_ci' AFTER `gender`;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `employees`
        CHANGE COLUMN `civil_status` `civil_status` ENUM('SINGLE','MARRIED','WIDOWED','SEPERATED','OTHERS') NOT NULL COLLATE 'utf8mb4_unicode_ci' AFTER `gender`;");
    }
}
