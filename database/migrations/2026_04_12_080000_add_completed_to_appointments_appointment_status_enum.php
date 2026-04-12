<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * MySQL ENUM for appointment_status did not include "Completed", causing
     * SQLSTATE[01000] 1265 Data truncated when saving a prescription.
     */
    public function up(): void
    {
        if (! Schema::hasTable('appointments')) {
            return;
        }

        $row = DB::selectOne(
            "SHOW COLUMNS FROM `appointments` WHERE Field = 'appointment_status'"
        );

        if (! $row || stripos($row->Type, 'enum(') !== 0) {
            return;
        }

        preg_match_all("/'((?:[^'\\\\]|\\\\.)*)'/", $row->Type, $matches);
        $values = $matches[1] ?? [];

        if (in_array('Completed', $values, true)) {
            return;
        }

        $values[] = 'Completed';

        $enumList = implode(',', array_map(static function (string $v) {
            return "'".str_replace(['\\', "'"], ['\\\\', "''"], $v)."'";
        }, $values));

        $null = $row->Null === 'YES' ? 'NULL' : 'NOT NULL';

        $defaultClause = '';
        if ($row->Default !== null) {
            $defaultClause = " DEFAULT '".str_replace("'", "''", $row->Default)."'";
        } elseif ($row->Null === 'YES') {
            $defaultClause = ' DEFAULT NULL';
        }

        DB::statement(
            "ALTER TABLE `appointments` MODIFY `appointment_status` ENUM({$enumList}) {$null}{$defaultClause}"
        );
    }

    /**
     * Reverting ENUM value removal is unsafe if any row uses "Completed".
     */
    public function down(): void
    {
    }
};
