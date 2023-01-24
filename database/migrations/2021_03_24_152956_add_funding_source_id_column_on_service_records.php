<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFundingSourceIdColumnOnServiceRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('service_records', function (Blueprint $table) {
            $table->unsignedBigInteger('funding_source_id')->nullable()->after('employee_group_id');
            $table->foreign('funding_source_id')->references('id')->on('funding_sources');
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
        Schema::table('service_records', function (Blueprint $table) {
            $table->dropForeign('service_records_funding_source_id_foreign');
            $table->dropColumn('funding_source_id');
        });
        Schema::enableForeignKeyConstraints();
    }
}
