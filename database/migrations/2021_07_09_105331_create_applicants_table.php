<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantsTable extends Migration
{

    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('middleName')->nullable();
            $table->string('nameExtension', 10)->nullable();

            $table->string('civilStatus');
            $table->string('birthdate', 15);
            $table->double('height', 3,2);
            $table->enum('gender', ['MALE','FEMALE']);
            $table->longText('address');
            $table->string('contactNumber', 25);
            $table->string('email');

            $table->string('currentPosition')->nullable();
            $table->string('employmentStatus')->nullable();
            $table->string('yearsInCurrentPosition')->nullable();
            $table->longText('college')->nullable();
            $table->longText('workExperience')->nullable();
            $table->longText('training')->nullable();
            $table->longText('eligibility')->nullable();

            $table->string('positionTitle');
            $table->integer('vacantOnPositions');
            $table->string('placeOfAssignment');
            $table->string('dateOfPublication', 15)->nullable();
            $table->string('positionEducation');
            $table->string('positionTraining');
            $table->string('positionExperience');
            $table->string('positionEligibility');

            $table->string('dateReceived', 15);
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applicants');
    }
}