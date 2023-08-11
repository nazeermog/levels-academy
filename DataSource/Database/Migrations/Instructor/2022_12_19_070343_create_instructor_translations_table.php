<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instructor_translations', function (Blueprint $table) {
            $table->id();
            $table->string('spec');
            $table->string('about');
            $table->string('country');
            $table->unsignedBigInteger('instructor_id')->index();
            $table->string('locale')->index();
            $table->unique(['instructor_id', 'locale']);
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
        Schema::dropIfExists('instructor_translations');
    }
};
