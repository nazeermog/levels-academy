<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Per-student record for a class session: whether it was given to THAT student,
 * what they learned (notes), and whether the parent has been charged / instructor
 * credited (so billing happens per student, at the moment the session is given).
 */
return new class extends Migration {
    public function up()
    {
        Schema::create('class_session_student', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_session_id')->index();
            $table->unsignedBigInteger('student_id')->index(); // users.id
            $table->boolean('is_given')->default(false);
            $table->text('notes')->nullable();                 // what the student learned this session
            $table->dateTime('given_at')->nullable();
            $table->boolean('charged')->default(false);        // parent charged + instructor credited (idempotency guard)
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->timestamps();

            $table->unique(['class_session_id', 'student_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('class_session_student');
    }
};
