<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmploymentStatusIdColumnOnPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('positions', function (Blueprint $table) {
            $table->unsignedBigInteger('employment_status_id')->after('level');
            $table->foreign('employment_status_id')->references('id')->on('employment_statuses');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('positions', function (Blueprint $table) {
            $table->dropForeign('positions_employment_status_id_foreign');
            $table->dropColumn('employment_status_id');
        });
        Schema::enableForeignKeyConstraints();
    }
}
