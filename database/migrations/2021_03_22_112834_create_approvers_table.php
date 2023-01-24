<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApproversTable extends Migration
{

    public function up()
    {
        Schema::create('approvers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leaves_1')->nullable();
            $table->foreign('leaves_1')->references('id')->on('employees');
            $table->unsignedBigInteger('leaves_2')->nullable();
            $table->foreign('leaves_2')->references('id')->on('employees');
            $table->unsignedBigInteger('leaves_3')->nullable();
            $table->foreign('leaves_3')->references('id')->on('employees');
            $table->unsignedBigInteger('ob_1')->nullable();
            $table->foreign('ob_1')->references('id')->on('employees');
            $table->unsignedBigInteger('ob_2')->nullable();
            $table->foreign('ob_2')->references('id')->on('employees');
            $table->unsignedBigInteger('ob_3')->nullable();
            $table->foreign('ob_3')->references('id')->on('employees');
            $table->unsignedBigInteger('overtime_1')->nullable();
            $table->foreign('overtime_1')->references('id')->on('employees');
            $table->unsignedBigInteger('overtime_2')->nullable();
            $table->foreign('overtime_2')->references('id')->on('employees');
            $table->unsignedBigInteger('overtime_3')->nullable();
            $table->foreign('overtime_3')->references('id')->on('employees');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('approvers');
    }
}