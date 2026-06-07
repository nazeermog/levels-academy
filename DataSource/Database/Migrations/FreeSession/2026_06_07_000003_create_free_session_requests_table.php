<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create('free_session_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // requesting user (users.id)
            $table->text('note')->nullable();               // optional message / preferred time
            $table->enum('status', ['pending', 'scheduled', 'cancelled'])->default('pending')->index();

            // Filled in when the admin assigns the request to an instructor slot.
            $table->unsignedBigInteger('instructor_id')->nullable();
            $table->unsignedBigInteger('availability_id')->nullable();
            $table->unsignedBigInteger('class_session_id')->nullable();
            $table->dateTime('scheduled_at')->nullable(); // final appointment time, UTC

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('free_session_requests');
    }
};
