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
        Schema::create('lesson_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lesson_id')->index();
            $table->string('title');
            $table->longText('desc')->nullable();
            $table->string('attachment_name')->nullable();
            $table->string('locale')->index();
            $table->unique(['lesson_id', 'locale']);
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
        Schema::dropIfExists('lesson_translations');
    }
};
