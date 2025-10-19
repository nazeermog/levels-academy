<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::table('class_sessions', function (Blueprint $table) {
            $table->unsignedBigInteger('class_session_type_id')->nullable()->after('content');
        });
    }

    public function down()
    {
        Schema::table('class_sessions', function (Blueprint $table) {
            $table->dropColumn('class_session_type_id');
        });
    }
};


