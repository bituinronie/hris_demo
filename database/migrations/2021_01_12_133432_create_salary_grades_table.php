<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryGradesTable extends Migration
{

    public function up()
    {
        Schema::create('salary_grades', function (Blueprint $table) {
            $table->id();
            $table->integer('salary_grade');
            $table->integer('tranche');
            $table->integer('step');
            $table->double('salary', 10,2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('salary_grades');
    }
}