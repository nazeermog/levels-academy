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
        Schema::create('practice_type_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('practice_id')->index();
            $table->string('title');
            $table->string('locale');
            $table->unique(['locale', 'practice_id']);
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
        Schema::dropIfExists('practice_translations');
    }
};
