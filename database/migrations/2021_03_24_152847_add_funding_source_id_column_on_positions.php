<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFundingSourceIdColumnOnPositions extends Migration
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
            $table->unsignedBigInteger('funding_source_id')->after('employment_status_id');
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
        Schema::table('positions', function (Blueprint $table) {
            $table->dropForeign('positions_funding_source_id_foreign');
            $table->dropColumn('funding_source_id');
        });
        Schema::enableForeignKeyConstraints();
    }
}
