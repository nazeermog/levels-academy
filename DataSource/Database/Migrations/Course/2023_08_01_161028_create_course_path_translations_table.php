<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_path_translations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('desc');
            $table->longText('about')->nullable();
            $table->longText('benefit')->nullable();
            $table->string('locale')->index();
            $table->unsignedBigInteger('course_path_id')->index();
            $table->unique(['course_path_id', 'locale']);
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
        Schema::dropIfExists('course_path_translations');
    }
};
