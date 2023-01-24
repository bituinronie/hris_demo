<?php
namespace App\Traits;

use Illuminate\Support\Facades\DB;

/**
 * MigrationTrait
 */
trait MigrationTrait
{
    public function updateEnum($table, $column, $values, $nullable = false, $default = null) {
        $quotedValues = collect($values)
            ->map(fn ($value) => "'${value}'")
            ->join(', ');

        $suffix = '';

        if (!$nullable)
            $suffix .= ' NOT NULL';

        if ($default)
            $suffix .= " DEFAULT '${default}'";

        $statement = <<<SQL
                        ALTER TABLE ${table} CHANGE COLUMN ${column} ${column} ENUM(${quotedValues}) ${suffix}
                        SQL;

        DB::statement($statement);
    }

    public function updateEnumToString($table, $column, $length = 50, $nullable = false, $default = null){

        $suffix = '';

        if (!$nullable)
            $suffix .= ' NOT NULL';

        if ($default)
            $suffix .= " DEFAULT '${default}'";

        $statement = <<<SQL
                        ALTER TABLE ${table} CHANGE COLUMN ${column} ${column} VARCHAR(${length}) ${suffix}
                        SQL;

        DB::statement($statement);
    }
}
