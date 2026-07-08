<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Stores each user's IANA timezone (e.g. "Asia/Dubai") so the SERVER can render
 * times in their local zone — for things a browser can't help with, like invite
 * emails and ICS calendar text. Auto-detected from the browser on login.
 */
return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'timezone')) {
                $table->string('timezone', 64)->nullable()->after('email');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'timezone')) {
                $table->dropColumn('timezone');
            }
        });
    }
};
