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
        Schema::create('practice_types', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('practice_types');
    }
};
