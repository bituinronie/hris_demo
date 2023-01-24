<?php

use App\Traits\MigrationTrait;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangesOnRequestTypesTableColumns extends Migration
{
    use MigrationTrait;

    private $TABLE = 'request_types';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->updateEnumToString($this->TABLE, 'based_on', 50, true);

        $this->updateEnum($this->TABLE, 'category', [
            'LEAVES','OB','OVERTIME','REQUEST'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->updateEnum($this->TABLE, 'based_on', [
            'SCHEDULE','CALENDAR'
        ]);

        $this->updateEnum($this->TABLE, 'category', [
            'LEAVES','OB','OVERTIME'
        ]);
    }
}
