<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

/**
 * Adds the 'trial_student' value to users.role so self-registered (API) users can
 * start as a trial before an admin upgrades them to a full 'student'.
 * role is an ENUM, so this is done with raw SQL (Schema/DBAL can't alter enums).
 */
return new class extends Migration {
    public function up()
    {
        DB::statement("ALTER TABLE `users` MODIFY COLUMN `role` ENUM('super_admin','admin','student','instructor','parentt','trial_student') NOT NULL");
    }

    public function down()
    {
        // Revert any trial students to plain students first so the value can be dropped.
        DB::statement("UPDATE `users` SET `role` = 'student' WHERE `role` = 'trial_student'");
        DB::statement("ALTER TABLE `users` MODIFY COLUMN `role` ENUM('super_admin','admin','student','instructor','parentt') NOT NULL");
    }
};
