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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 8, 3);
            $table->unsignedBigInteger('taxonomy_id')->index();
            $table->unsignedBigInteger('instructor_id')->index();
            $table->boolean('is_active')->default(1);
            $table->unsignedBigInteger('course_path_id')->index()->nullable();
            $table->integer('ordering')->index()->nullable();
            $table->boolean('is_auto_join');
            $table->string('photo');
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
        Schema::dropIfExists('courses');
    }
};
