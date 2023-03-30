<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->index();
            $table->unsignedBigInteger('lesson_id')->index();
            $table->unsignedBigInteger('course_id')->index();
            $table->timestamps();
            $table->foreign('course_id')->on('courses')->references('id')->onDelete('cascade');
            $table->foreign('student_id')->on('students')->references('user_id')->onDelete('cascade');
            $table->foreign('lesson_id')->on('lessons')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_students');
    }
};
