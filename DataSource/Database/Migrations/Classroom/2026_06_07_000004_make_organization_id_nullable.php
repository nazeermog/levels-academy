<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

/**
 * Organizations can be turned off (config('features.organizations')), in which case
 * records are created with no organization. These columns were NOT NULL, causing
 * "Column 'organization_id' cannot be null" errors. Make them nullable so a no-org
 * value (NULL) is accepted everywhere, matching users.organization_id which is already nullable.
 */
return new class extends Migration {
    public function up()
    {
        DB::statement("ALTER TABLE `classrooms` MODIFY `organization_id` BIGINT UNSIGNED NULL");
        DB::statement("ALTER TABLE `class_session_types` MODIFY `organization_id` BIGINT UNSIGNED NULL");
    }

    public function down()
    {
        // Revert to NOT NULL (will fail if any NULL/0-org rows exist).
        DB::statement("ALTER TABLE `classrooms` MODIFY `organization_id` BIGINT UNSIGNED NOT NULL");
        DB::statement("ALTER TABLE `class_session_types` MODIFY `organization_id` BIGINT UNSIGNED NOT NULL");
    }
};
