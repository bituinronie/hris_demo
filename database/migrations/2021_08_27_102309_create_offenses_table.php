<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffensesTable extends Migration
{

    public function up()
    {
        Schema::create('offenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->string('recieved_date', 15);
            $table->string('type');
            $table->string('offense');
            $table->longText('corrective_action_taken');
            $table->string('status');
            $table->string('remarks')->nullable();
            $table->string('memo_date', 15);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('offenses');
    }
}