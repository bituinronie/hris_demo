<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTrainingsTable extends Migration
{

    public function up()
    {
        Schema::create('employee_trainings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->unsignedBigInteger('training_id')->nullable();
            $table->foreign('training_id')->references('id')->on('trainings');
            $table->string('date_from', 15);
            $table->string('date_to', 15);
            $table->integer('number_of_hours');
            $table->boolean('show_pds')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_trainings');
    }
}