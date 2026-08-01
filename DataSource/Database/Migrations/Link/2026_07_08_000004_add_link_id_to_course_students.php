<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * A link a student clicked is recorded in course_students (same completion-signal
 * table as lesson_id / practice_id / worksheet_id), so it counts toward progress.
 */
return new class extends Migration {
    public function up()
    {
        Schema::table('course_students', function (Blueprint $table) {
            if (!Schema::hasColumn('course_students', 'link_id')) {
                $table->unsignedBigInteger('link_id')->nullable()->index()->after('worksheet_id');
            }
        });
    }

    public function down()
    {
        Schema::table('course_students', function (Blueprint $table) {
            if (Schema::hasColumn('course_students', 'link_id')) {
                $table->dropColumn('link_id');
            }
        });
    }
};
