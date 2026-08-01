<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Worksheets: a PDF/Word file uploaded by an admin that can be attached to any
 * course step (normal or classroom) — e.g. a "letter A" worksheet under the
 * "letter A" class session. A student opening one marks it read (progress).
 */
return new class extends Migration {
    public function up()
    {
        Schema::create('worksheets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file');                        // public storage URL, e.g. /storage/worksheets/x.pdf
            $table->string('original_name')->nullable();   // filename as uploaded
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('worksheets');
    }
};
