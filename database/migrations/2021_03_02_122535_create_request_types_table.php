<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestTypesTable extends Migration
{

    public function up()
    {
        Schema::create('request_types', function (Blueprint $table) {
            $table->id();
            $table->string('code', 150);
            $table->string('description');
            $table->enum('filing_period_type', ['BEFORE','EITHER','AFTER','MONTH','FROM_TO','ANYTIME']);

            $table->longText('filing_period_month')->nullable();
            $table->integer('filing_period_days')->nullable();
            $table->string('filing_period_from')->nullable();
            $table->string('filing_period_to')->nullable();

            $table->double('request_limit_min')->nullable();
            $table->double('request_limit_max')->nullable();
            $table->enum('category', ['LEAVES','OB','OVERTIME']);
            $table->enum('based_on', ['SCHEDULE','CALENDAR']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('request_types');
    }
}