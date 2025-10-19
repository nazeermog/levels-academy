<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create('class_session_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2)->default(0);
            $table->unsignedBigInteger('organization_id')->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('class_session_types');
    }
};


