<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSpecialSchedulesColumnsOnEmployeeSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_schedules', function (Blueprint $table) {
            $table->enum('schedule_type',['REGULAR','SPECIAL'])->default('REGULAR')->after('employee_id');
            $table->json('special_schedule')->nullable()->after('schedule_id');
            $table->unsignedBigInteger('schedule_id')->nullable()->change();
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
            $table->dropColumn('schedule_type');
            $table->dropColumn('special_schedule');
            $table->unsignedBigInteger('schedule_id')->change();
        });
    }
}
