<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::table('course_contents', function (Blueprint $table) {
            // A content "box"/step is either a normal step (lessons/practices/quizzes)
            // or a classroom step that holds class sessions.
            $table->string('step_type', 20)->default('normal')->after('ordering');
        });
    }

    public function down()
    {
        Schema::table('course_contents', function (Blueprint $table) {
            $table->dropColumn('step_type');
        });
    }
};
