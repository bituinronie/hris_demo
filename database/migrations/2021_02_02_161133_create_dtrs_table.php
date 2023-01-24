<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDtrsTable extends Migration
{

    public function up()
    {
        Schema::create('dtrs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->date('ref_date');
            $table->timestamp('time_in')->nullable();
            $table->timestamp('lunch_out')->nullable();
            $table->timestamp('lunch_in')->nullable();
            $table->timestamp('time_out')->nullable();
            $table->string('reason')->nullable();
            $table->timestamps();

            $table->index(['employee_id', 'ref_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('dtrs');
    }
}