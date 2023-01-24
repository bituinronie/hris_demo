<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppraisalsTable extends Migration
{

    public function up()
    {
        Schema::create('appraisals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->string('date', 15);
            $table->enum('semester', ['1ST','2ND','OTHERS']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appraisals');
    }
}