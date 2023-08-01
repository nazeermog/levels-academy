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
        Schema::create('course_content_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_content_id')->index();
            $table->string('title');
            $table->string('desc');
            $table->string('locale')->index();
            $table->unique(['course_content_id', 'locale']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_content_translations');
    }
};
