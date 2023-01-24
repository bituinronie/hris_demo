<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildrensTable extends Migration
{

    public function up()
    {
        Schema::create('childrens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->string('name', 200);
            $table->string('birth_date', 15);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('childrens');
    }
}