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
        Schema::create('answer_question_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('answer_question_id');
            $table->text('answer');
            $table->string('locale')->index();
            $table->unique(['locale', 'answer_question_id']);
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
        Schema::dropIfExists('answer_question_translations');
    }
};
