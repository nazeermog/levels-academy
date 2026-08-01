<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Links: a simple titled URL attached to a course step. Unlike worksheets there
 * is no separate admin CRUD — a link is created inline while building/editing a
 * course. A student clicking it marks it completed (counts toward progress).
 */
return new class extends Migration {
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('url', 2048);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('links');
    }
};
