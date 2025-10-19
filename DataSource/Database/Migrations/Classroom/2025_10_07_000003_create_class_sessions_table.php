<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create('class_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('classroom_id')->index();
            $table->unsignedBigInteger('instructor_id')->index(); // users.id
            $table->dateTime('held_at');
            $table->text('content')->nullable(); // what was presented
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('class_sessions');
    }
};


