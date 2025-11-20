<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::table('classrooms', function (Blueprint $table) {
            $table->unsignedBigInteger('class_session_type_id')->nullable()->after('instructor_id');
            $table->string('days_of_week')->nullable()->after('class_session_type_id');
            // Preferred start time for sessions (HH:MM:SS)
            $table->time('session_time')->nullable()->after('days_of_week');
          });
    }

    public function down()
    {
        Schema::table('classrooms', function (Blueprint $table) {
            $table->dropColumn('class_session_type_id');
            $table->dropColumn('days_of_week');
            $table->dropColumn('session_time');
        });
    }
};



