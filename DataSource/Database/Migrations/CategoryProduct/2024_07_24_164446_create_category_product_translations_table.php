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
        Schema::create('category_product_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_product_id')->index();
            $table->string('title')->nullable();
            $table->string('desc')->nullable();
            $table->string('locale')->index();
            $table->unique(['category_product_id', 'locale']);
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
        Schema::dropIfExists('category_product_translations');
    }
};
