<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundingSourcesTable extends Migration
{

    public function up()
    {
        Schema::create('funding_sources', function (Blueprint $table) {
            $table->id();
            $table->string('code', 150)->unique();
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('funding_sources');
    }
}