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
        Schema::create('Guest_taxonomies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('taxonomy_id')->index();
            $table->unsignedBigInteger('Guest_id')->index();
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
        Schema::dropIfExists('Guest_taxonomies');
    }
};
