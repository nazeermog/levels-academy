<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::table('class_sessions', function (Blueprint $table) {

            $table->string('zoom_url', 1024)->nullable()->after('content');
        });
    }

    public function down()
    {
        Schema::table('class_sessions', function (Blueprint $table) {
            $table->dropColumn('zoom_url');
        });
    }
};
