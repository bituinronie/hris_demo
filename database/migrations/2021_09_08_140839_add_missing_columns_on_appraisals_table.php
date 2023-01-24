<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumnsOnAppraisalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appraisals', function (Blueprint $table) {
            $table->string('remarks')->nullable()->after('date');
            $table->string('monthTo', 2)->nullable()->after('date');
            $table->string('monthFrom', 2)->nullable()->after('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appraisals', function (Blueprint $table) {
            $table->dropColumn('remarks');
            $table->dropColumn('monthTo');
            $table->dropColumn('monthFrom');
        });
    }
}
