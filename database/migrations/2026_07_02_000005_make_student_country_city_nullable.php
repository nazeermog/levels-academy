<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

/**
 * Make students.country / students.city nullable so the register API can create
 * a (trial) student without them. Raw SQL keeps it independent of doctrine/dbal.
 */
return new class extends Migration {
    public function up()
    {
        DB::statement("ALTER TABLE `students` MODIFY `country` VARCHAR(255) NULL");
        DB::statement("ALTER TABLE `students` MODIFY `city` VARCHAR(255) NULL");
    }

    public function down()
    {
        // Backfill nulls before restoring the NOT NULL constraint.
        DB::statement("UPDATE `students` SET `country` = '' WHERE `country` IS NULL");
        DB::statement("UPDATE `students` SET `city` = '' WHERE `city` IS NULL");
        DB::statement("ALTER TABLE `students` MODIFY `country` VARCHAR(255) NOT NULL");
        DB::statement("ALTER TABLE `students` MODIFY `city` VARCHAR(255) NOT NULL");
    }
};
