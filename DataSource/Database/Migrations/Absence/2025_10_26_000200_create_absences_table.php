<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_session_id')->index();
            $table->unsignedBigInteger('student_id')->index(); // users.id (student user_id)
            $table->dateTime('requested_at');
            $table->enum('status', ['pending','approved','rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['class_session_id', 'student_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('absences');
    }
};

?>


