<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSpecialScheduleIdColumnOnEmployeeSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_schedules', function (Blueprint $table) {
            $table->dropColumn('special_schedule');
            $table->unsignedBigInteger('special_schedule_id')->nullable()->after('schedule_id');
            $table->foreign('special_schedule_id')->references('id')->on('special_schedules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_schedules', function (Blueprint $table) {
            $table->json('special_schedule')->nullable()->after('schedule_id');
            $table->dropForeign('employee_schedules_special_schedule_id_foreign');
            $table->dropColumn('special_schedules_id');
        });
    }
}
