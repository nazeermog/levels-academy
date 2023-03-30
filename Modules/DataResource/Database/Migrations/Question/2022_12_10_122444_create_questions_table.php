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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->integer('point');
            $table->unsignedBigInteger('practice_id')->index();
            $table->enum('question_type',['radio_answer','true_false_answer','checkbox_answer','filling_blank_answer','sortable','text_answer']);
            $table->timestamps();
            $table->foreign('practice_id')->on('practices')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
};
