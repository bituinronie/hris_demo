<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMfosTable extends Migration
{

    public function up()
    {
        Schema::create('mfos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appraisal_id');
            $table->foreign('appraisal_id')->references('id')->on('appraisals');
            $table->string('number');
            $table->string('title');
            $table->longText('description')->nullable();
            $table->integer('Q')->nullable();
            $table->integer('E')->nullable();
            $table->integer('T')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mfos');
    }
}