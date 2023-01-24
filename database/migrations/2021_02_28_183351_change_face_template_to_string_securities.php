<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFaceTemplateToStringSecurities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('securities', function (Blueprint $table) {
            $table->text('template1')->nullable()->change();
            $table->text('template2')->nullable()->change();
            $table->text('face_template')->nullable()->change();
            $table->json('kiosk_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('securities', function (Blueprint $table) {
            $table->binary('template1')->nullable()->change();
            $table->binary('template2')->nullable()->change();
            $table->binary('face_template')->nullable()->change();
            $table->dropColumn('kiosk_name');
        });
    }
}
