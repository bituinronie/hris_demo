<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{

    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('employee_group_id')->nullable();
            $table->foreign('employee_group_id')->references('id')->on('employee_groups');
            $table->string('employee_number', 10);
            $table->string('last_name', 75);
            $table->string('first_name', 75);
            $table->string('middle_name', 75)->nullable();
            $table->string('name_extension', 10)->nullable();
            $table->string('birth_date', 15);
            $table->string('birth_place')->nullable();
            $table->enum('gender', ['MALE','FEMALE']);
            $table->enum('civil_status', ['SINGLE','MARRIED','WIDOWED','SEPERATED','OTHERS']);
            $table->double('height', 3,2)->nullable();
            $table->double('weight', 5,2)->nullable();
            $table->enum('blood_type', ['A+','A-','B+','B-','AB+','AB-','O+','O-'])->nullable();
            $table->string('gsis', 20)->nullable();
            $table->string('pagibig', 20)->nullable();
            $table->string('philhealth', 20)->nullable();
            $table->string('sss', 20)->nullable();
            $table->string('tin', 20)->nullable();
            $table->enum('citizenship', ['FILIPINO','DUAL_CITIZEN'])->nullable();
            $table->enum('citizenship_by', ['BIRTH','NATURALIZATION'])->nullable();
            $table->string('citizenship_by_country', 100)->nullable();
            $table->string('residential_housenum', 100)->nullable();
            $table->string('residential_street', 100)->nullable();
            $table->string('residential_subdivision', 100)->nullable();
            $table->string('residential_barangay', 100)->nullable();
            $table->string('residential_city', 100)->nullable();
            $table->string('residential_province', 100)->nullable();
            $table->string('residential_zipcode', 4)->nullable();
            $table->string('permanent_housenum', 100)->nullable();
            $table->string('permanent_street', 100)->nullable();
            $table->string('permanent_subdivision', 100)->nullable();
            $table->string('permanent_barangay', 100)->nullable();
            $table->string('permanent_city', 100)->nullable();
            $table->string('permanent_province', 100)->nullable();
            $table->string('permanent_zipcode', 4)->nullable();
            $table->string('telephone', 20)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('email')->unique();
            $table->string('spouse_last_name', 75)->nullable();
            $table->string('spouse_first_name', 75)->nullable();
            $table->string('spouse_middle_name', 75)->nullable();
            $table->string('spouse_name_extension', 10)->nullable();
            $table->string('spouse_occupation', 100)->nullable();
            $table->string('spouse_telephone', 15)->nullable();
            $table->string('spouse_employer_business')->nullable();
            $table->string('spouse_business_address')->nullable();
            $table->string('father_last_name', 75)->nullable();
            $table->string('father_first_name', 75)->nullable();
            $table->string('father_middle_name', 75)->nullable();
            $table->string('father_name_extension', 10)->nullable();
            $table->string('mother_last_name', 75)->nullable();
            $table->string('mother_first_name', 75)->nullable();
            $table->string('mother_middle_name', 75)->nullable();
            $table->boolean('is_affiliated_third')->nullable();
            $table->text('affiliated_third')->nullable();
            $table->boolean('is_affiliated_fourth')->nullable();
            $table->text('affiliated_fourth')->nullable();
            $table->boolean('is_found_guilty')->nullable();
            $table->text('found_guilty')->nullable();
            $table->boolean('is_criminally_charged')->nullable();
            $table->string('criminally_charged_date', 15)->nullable();
            $table->text('criminally_charged_status')->nullable();
            $table->boolean('is_convicted')->nullable();
            $table->text('convicted')->nullable();
            $table->boolean('is_separated_service')->nullable();
            $table->text('separated_service')->nullable();
            $table->boolean('is_candidate')->nullable();
            $table->text('candidate')->nullable();
            $table->boolean('is_resigned')->nullable();
            $table->text('resigned')->nullable();
            $table->boolean('is_immigrant')->nullable();
            $table->text('immigrant')->nullable();
            $table->boolean('is_indigenous')->nullable();
            $table->text('indigenous')->nullable();
            $table->boolean('is_disabled')->nullable();
            $table->text('disabled')->nullable();
            $table->boolean('is_solo')->nullable();
            $table->text('solo')->nullable();
            $table->string('government_id_type', 100)->nullable();
            $table->string('government_id_number', 100)->nullable();
            $table->string('issued_date', 15)->nullable();
            $table->string('issued_place')->nullable();

            $table->longText('memberships')->nullable();
            $table->longText('skills')->nullable();
            $table->longText('recognitions')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
}