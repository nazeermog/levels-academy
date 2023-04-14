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
        Schema::create('partner_taxonomies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('taxonomy_id')->index();
            $table->unsignedBigInteger('partner_id')->index();
            $table->timestamps();
            $table->foreign('partner_id')->on('partners')->references('id')->onDelete('cascade');
            $table->foreign('taxonomy_id')->on('taxonomies')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partner_taxonomies');
    }
};
