<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationTable extends Migration
{

    public function up()
    {
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->enum('level', ['ELEMENTARY','SECONDARY','VOCATIONAL','COLLEGE','GRADUATE STUDIES']);
            $table->string('school_name');
            $table->string('course')->nullable();
            $table->year('attended_from');
            $table->year('attended_to')->nullable();
            $table->boolean('graduated')->nullable()->default(0);
            $table->string('highest_level')->nullable();
            $table->year('year_graduated')->nullable();
            $table->string('honors')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('education');
    }
}