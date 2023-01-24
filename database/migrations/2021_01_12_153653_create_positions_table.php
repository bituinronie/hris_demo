<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionsTable extends Migration
{

    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('former_position')->nullable();
            $table->string('item_number', 30)->nullable()->unique();
            $table->string('place_of_work')->nullable();

            $table->unsignedBigInteger('salary_grade_id');
            $table->foreign('salary_grade_id')->references('id')->on('salary_grades');

            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->foreign('supervisor_id')->references('id')->on('positions');

            $table->unsignedBigInteger('division_id');
            $table->foreign('division_id')->references('id')->on('divisions');

            $table->enum('classification', ['KEY','TECHNICAL','SUPPORT TO THE TECHNICAL','ADMINISTRATIVE']);
            $table->enum('level', ['1ST','2ND','3RD']);

            $table->enum('contact_internal_executive', ['OCCASIONAL','FREQUENT'])->nullable();
            $table->enum('contact_internal_supervisor', ['OCCASIONAL','FREQUENT'])->nullable();
            $table->enum('contact_internal_non_supervisor', ['OCCASIONAL','FREQUENT'])->nullable();
            $table->enum('contact_internal_staff', ['OCCASIONAL','FREQUENT'])->nullable();
            $table->enum('contact_external_public', ['OCCASIONAL','FREQUENT'])->nullable();
            $table->enum('contact_external_agencies', ['OCCASIONAL','FREQUENT'])->nullable();
            $table->string('contact_external_others', 150)->nullable();
            $table->enum('office_work', ['OCCASIONAL','FREQUENT'])->nullable();
            $table->enum('field_work', ['OCCASIONAL','FREQUENT'])->nullable();
            $table->string('other_work')->nullable();
            $table->text('general_function')->nullable();
            $table->text('job_summary')->nullable();
            $table->text('education')->nullable();
            $table->text('experience')->nullable();
            $table->text('training')->nullable();
            $table->text('eligibility')->nullable();
            $table->text('core_compentencies')->nullable();
            $table->text('core_competency_level')->nullable();
            $table->text('leadership_competencies')->nullable();
            $table->text('leadership_compentency_level')->nullable();
            $table->text('percentage_working_time')->nullable();
            $table->text('duties_responsibilities')->nullable();
            $table->text('duties_competency_level')->nullable();
            $table->longText('equipments')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('positions');
    }
}