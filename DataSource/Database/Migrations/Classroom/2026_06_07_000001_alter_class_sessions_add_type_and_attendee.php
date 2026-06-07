<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        // Add session "type": normal (existing behaviour) vs free (trial appointment).
        // Raw statement keeps the ENUM portable and avoids doctrine/dbal enum quirks.
        DB::statement("ALTER TABLE `class_sessions` ADD COLUMN `type` ENUM('normal','free') NOT NULL DEFAULT 'normal' AFTER `class_session_type_id`");

        // Free sessions are not tied to a classroom, so classroom_id must allow NULL.
        DB::statement("ALTER TABLE `class_sessions` MODIFY `classroom_id` BIGINT UNSIGNED NULL");

        // The attendee of a free session (the requesting user). Normal sessions leave this NULL.
        Schema::table('class_sessions', function (Blueprint $table) {
            $table->unsignedBigInteger('student_user_id')->nullable()->index()->after('instructor_id');
        });
    }

    public function down()
    {
        Schema::table('class_sessions', function (Blueprint $table) {
            $table->dropColumn('student_user_id');
        });

        DB::statement("ALTER TABLE `class_sessions` DROP COLUMN `type`");

        // Restore NOT NULL. (Will fail if free-session rows with NULL classroom_id remain.)
        DB::statement("ALTER TABLE `class_sessions` MODIFY `classroom_id` BIGINT UNSIGNED NOT NULL");
    }
};
