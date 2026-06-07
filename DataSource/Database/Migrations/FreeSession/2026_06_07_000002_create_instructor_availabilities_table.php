<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create('instructor_availabilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instructor_id')->index(); // users.id
            $table->dateTime('start_at'); // stored in UTC
            $table->dateTime('end_at');   // stored in UTC
            $table->enum('status', ['available', 'booked'])->default('available')->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('instructor_availabilities');
    }
};
