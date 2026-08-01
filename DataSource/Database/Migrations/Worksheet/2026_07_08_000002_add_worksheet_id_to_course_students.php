<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * course_students is the single "completion signal" table: a row with lesson_id
 * = lesson watched, practice_id = practice done. This adds worksheet_id so a
 * worksheet the student opened counts the same way for progress.
 */
return new class extends Migration {
    public function up()
    {
        Schema::table('course_students', function (Blueprint $table) {
            if (!Schema::hasColumn('course_students', 'worksheet_id')) {
                $table->unsignedBigInteger('worksheet_id')->nullable()->index()->after('practice_id');
            }
        });
    }

    public function down()
    {
        Schema::table('course_students', function (Blueprint $table) {
            if (Schema::hasColumn('course_students', 'worksheet_id')) {
                $table->dropColumn('worksheet_id');
            }
        });
    }
};
