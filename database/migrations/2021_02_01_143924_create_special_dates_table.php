<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialDatesTable extends Migration
{

    public function up()
    {
        Schema::create('special_dates', function (Blueprint $table) {
            $table->id();
            $table->date('reference_date');
            $table->time('reference_time')->nullable();
            $table->enum('type', ['SPECIAL','LEGAL','SUSPENSION','FLAG_CEREMONY']);
            $table->string('description')->nullable();
            $table->unsignedBigInteger('employee_group_id')->nullable();
            $table->foreign('employee_group_id')->references('id')->on('employee_groups');
            $table->boolean('is_fixed')->default(false);
            $table->boolean('is_required')->nullable()->default(false);
            $table->boolean('use_description')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('special_dates');
    }
}