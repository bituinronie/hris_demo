<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRecordsTable extends Migration
{

    public function up()
    {
        Schema::create('service_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->string('date_from', 15);
            $table->string('date_to', 15)->nullable();
            $table->unsignedBigInteger('employee_group_id');
            $table->foreign('employee_group_id')->references('id')->on('employee_groups');
            $table->unsignedBigInteger('position_id')->nullable();
            $table->foreign('position_id')->references('id')->on('positions');
            $table->string('positionOnPrint')->nullable();
            $table->double('salary', 10,2);
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->foreign('assigned_to')->references('id')->on('divisions');
            $table->string('divisionOnPrint')->nullable();
            $table->unsignedBigInteger('assigned_supervisor')->nullable();
            $table->foreign('assigned_supervisor')->references('id')->on('employees');
            $table->string('supervisorOnPrint')->nullable();
            $table->string('date_seperation', 15)->nullable();
            $table->string('cause')->nullable();
            $table->unsignedBigInteger('employment_status_id');
            $table->foreign('employment_status_id')->references('id')->on('employment_statuses');
            $table->unsignedBigInteger('remark_id')->nullable();
            $table->foreign('remark_id')->references('id')->on('remarks');
            $table->string('awol_at')->nullable();
            $table->boolean('show_in_reports')->default(false);
            $table->boolean('is_uniformed')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->boolean('is_exempted')->default(false);
            $table->boolean('date_hired')->default(false);
            $table->string('place_of_work')->nullable();
            $table->boolean('is_wfh')->default(false);
            $table->enum('classification', ['KEY','TECHNICAL','SUPPORT TO THE TECHNICAL','ADMINISTRATIVE']);
            $table->enum('level', ['1ST','2ND','3RD']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_records');
    }
}