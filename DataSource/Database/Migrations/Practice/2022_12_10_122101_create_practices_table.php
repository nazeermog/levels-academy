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
        Schema::create('practices', function (Blueprint $table) {
            $table->id();
//            $table->unsignedBigInteger('course_id')->index();
            // $table->unsignedBigInteger('student_id')->index();
            $table->timestamps();
            // $table->foreign('student_id')->on('students')->references('user_id')->onDelete('cascade');
            $table->boolean('is_active')->default(1);
          //  $table->foreign('course_id')->on('courses')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('practices');
    }
};
