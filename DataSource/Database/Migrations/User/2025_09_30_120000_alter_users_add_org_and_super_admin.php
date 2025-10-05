<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up()
    {
        // Ensure organization_id exists
        if (! Schema::hasColumn('users', 'organization_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('organization_id')->nullable()->index()->after('role');
            });
        }

        // Ensure enum includes super_admin (MySQL-specific)
        try {
            DB::statement("ALTER TABLE `users` MODIFY COLUMN `role` ENUM('super_admin','admin','student','instructor','parentt') NOT NULL");
        } catch (\Throwable $e) {
            // ignore if not MySQL/enum differs; administrators can adjust manually
        }
    }

    public function down()
    {
        // Keep organization_id; dropping can break data. Only try to revert enum.
        try {
            DB::statement("ALTER TABLE `users` MODIFY COLUMN `role` ENUM('admin','student','instructor','parentt') NOT NULL");
        } catch (\Throwable $e) {
            // ignore
        }
    }
};


