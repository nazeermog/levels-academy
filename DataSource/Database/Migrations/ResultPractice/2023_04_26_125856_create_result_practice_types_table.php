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
        Schema::create('result_practice_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('result_practice_id');
            $table->integer('seconds_speed')->nullable();
            $table->integer('card_number')->nullable();
            $table->integer('range_number_from')->nullable();
            $table->integer('range_number_to')->nullable();
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
        Schema::dropIfExists('result_practice_types');
    }
};
