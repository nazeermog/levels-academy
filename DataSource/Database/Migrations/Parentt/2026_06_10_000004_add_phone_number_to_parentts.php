<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::table('parentts', function (Blueprint $table) {
            $table->string('phone_number', 30)->nullable()->after('last_name');
        });

        // Backfill existing parents with a random placeholder Syrian mobile number (e.g. 0966433215).
        // These are generated stand-ins meant to be replaced with real numbers.
        foreach (DB::table('parentts')->whereNull('phone_number')->pluck('user_id') as $userId) {
            DB::table('parentts')->where('user_id', $userId)->update([
                'phone_number' => '09' . str_pad((string) random_int(0, 99999999), 8, '0', STR_PAD_LEFT),
            ]);
        }
    }

    public function down()
    {
        Schema::table('parentts', function (Blueprint $table) {
            $table->dropColumn('phone_number');
        });
    }
};
