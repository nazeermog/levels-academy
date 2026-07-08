<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::table('class_sessions', function (Blueprint $table) {

            $table->boolean('is_given')->default(false)->after('type');
        });
    }

    public function down()
    {
        Schema::table('class_sessions', function (Blueprint $table) {
            $table->dropColumn('is_given');
        });
    }
};
