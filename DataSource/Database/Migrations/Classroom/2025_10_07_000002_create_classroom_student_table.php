<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create('classroom_student', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('classroom_id')->index();
            $table->unsignedBigInteger('student_id')->index(); // references users.id (student user_id)
            $table->timestamps();
            $table->unique(['classroom_id', 'student_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('classroom_student');
    }
};


