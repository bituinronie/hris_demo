<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRequestColumnsOnApproversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('approvers', function (Blueprint $table) {
            $table->unsignedBigInteger('request_3')->nullable()->after('overtime_3');
            $table->foreign('request_3')->references('id')->on('employees');
            $table->unsignedBigInteger('request_2')->nullable()->after('overtime_3');
            $table->foreign('request_2')->references('id')->on('employees');
            $table->unsignedBigInteger('request_1')->nullable()->after('overtime_3');
            $table->foreign('request_1')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
       
        Schema::table('approvers', function (Blueprint $table) {
            $table->dropForeign('approvers_request_1_foreign');
            $table->dropForeign('approvers_request_2_foreign');
            $table->dropForeign('approvers_request_3_foreign');
            $table->dropColumn('request_1');
            $table->dropColumn('request_2');
            $table->dropColumn('request_3');
        });
        Schema::enableForeignKeyConstraints();

    }
}
