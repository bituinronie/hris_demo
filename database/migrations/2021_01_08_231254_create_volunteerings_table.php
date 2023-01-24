<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteeringsTable extends Migration
{

    public function up()
    {
        Schema::create('volunteerings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->string('organization');
            $table->string('date_from', 15);
            $table->string('date_to', 15)->nullable();
            $table->string('number_of_hours', 1000);
            $table->string('position');
            $table->string('nature_of_work', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('volunteerings');
    }
}