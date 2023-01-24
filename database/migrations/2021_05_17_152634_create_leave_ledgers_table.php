<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveLedgersTable extends Migration
{

    public function up()
    {
        Schema::create('leave_ledgers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->timestamp('from')->nullable();
            $table->timestamp('to')->nullable();
            $table->unsignedBigInteger('request_type_id');
            $table->foreign('request_type_id')->references('id')->on('request_types');
            $table->double('credit', 6,3)->nullable();
            $table->longText('ot_json')->nullable();
            $table->integer('status');
            $table->string('reason')->nullable();
            $table->string('proof_type')->nullable();
            $table->string('ob_venue')->nullable();
            $table->boolean('is_paid')->nullable();
            $table->string('remarks')->nullable();
            $table->boolean('is_start')->default(false);
            $table->longText('approverStatus')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('leave_ledgers');
    }
}