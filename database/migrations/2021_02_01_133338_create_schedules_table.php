<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{

    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('description', 150);
            $table->time('mon_time_in')->nullable();
            $table->time('mon_lunch_out')->nullable();
            $table->time('mon_lunch_in')->nullable();
            $table->time('mon_time_out')->nullable();
            $table->time('tue_time_in')->nullable();
            $table->time('tue_lunch_out')->nullable();
            $table->time('tue_lunch_in')->nullable();
            $table->time('tue_time_out')->nullable();
            $table->time('wed_time_in')->nullable();
            $table->time('wed_lunch_out')->nullable();
            $table->time('wed_lunch_in')->nullable();
            $table->time('wed_time_out')->nullable();
            $table->time('thu_time_in')->nullable();
            $table->time('thu_lunch_out')->nullable();
            $table->time('thu_lunch_in')->nullable();
            $table->time('thu_time_out')->nullable();
            $table->time('fri_time_in')->nullable();
            $table->time('fri_lunch_out')->nullable();
            $table->time('fri_lunch_in')->nullable();
            $table->time('fri_time_out')->nullable();
            $table->time('sat_time_in')->nullable();
            $table->time('sat_lunch_out')->nullable();
            $table->time('sat_lunch_in')->nullable();
            $table->time('sat_time_out')->nullable();
            $table->time('sun_time_in')->nullable();
            $table->time('sun_lunch_out')->nullable();
            $table->time('sun_lunch_in')->nullable();
            $table->time('sun_time_out')->nullable();
            $table->time('flexi_from')->nullable();
            $table->time('flexi_to')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}