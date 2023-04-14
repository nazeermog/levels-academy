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
        Schema::create('taxonomy_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('taxonomy_id')->index();
            $table->string('title')->nullable();
            $table->string('desc')->nullable();
            $table->string('locale')->index();
            $table->unique(['taxonomy_id', 'locale']);
            $table->foreign('taxonomy_id')->references('id')->on('taxonomies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taxonomy_translations');
    }
};
