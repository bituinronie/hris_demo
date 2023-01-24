<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkExperiencesTable extends Migration
{

    public function up()
    {
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->string('position', 150);
            $table->string('date_from', 15);
            $table->string('date_to', 15)->nullable();
            $table->string('company');
            $table->string('salary');
            $table->string('pay_grade', 50);
            $table->string('status_of_appointment', 200)->nullable();
            $table->string('sector')->nullable();
            $table->boolean('is_government_service');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('work_experiences');
    }
}