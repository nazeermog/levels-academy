<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{

    public function up()
    {
        DB::statement('ALTER TABLE `transactions` MODIFY `course_id` BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE `transactions` MODIFY `student_id` BIGINT UNSIGNED NULL');
    }

    public function down()
    {
        DB::statement('ALTER TABLE `transactions` MODIFY `course_id` BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE `transactions` MODIFY `student_id` BIGINT UNSIGNED NOT NULL');
    }
};
