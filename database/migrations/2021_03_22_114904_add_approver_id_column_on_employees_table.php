<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApproverIdColumnOnEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('employees', function (Blueprint $table) {
            $table->unsignedBigInteger('approver_id')->after('user_id')->nullable();
            $table->foreign('approver_id')->references('id')->on('approvers');
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
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign('employees_approver_id_foreign');
            $table->dropColumn('approver_id');
        });
        Schema::enableForeignKeyConstraints();
    }
}
