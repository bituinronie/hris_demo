<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecuritiesTable extends Migration
{

    public function up()
    {
        Schema::create('securities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->string('rfid', 10)->nullable();
            $table->binary('template1')->nullable();
            $table->integer('template1_number')->nullable();
            $table->binary('template2')->nullable();
            $table->integer('template2_number')->nullable();
            $table->integer('finger_mask')->nullable();
            $table->binary('face_template')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('securities');
    }
}