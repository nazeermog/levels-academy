<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        // Add the "given" lifecycle state (instructor confirms the session happened).
        // Enum changes can't go through Schema::change()/DBAL reliably, so use raw SQL.
        DB::statement("ALTER TABLE free_session_requests MODIFY COLUMN status ENUM('pending','scheduled','cancelled','given') NOT NULL DEFAULT 'pending'");

        Schema::table('free_session_requests', function (Blueprint $table) {
            $table->text('instructor_note')->nullable()->after('note'); // instructor's note about how the session went
            $table->dateTime('given_at')->nullable()->after('scheduled_at'); // when the instructor marked it given (UTC)
        });
    }

    public function down()
    {
        Schema::table('free_session_requests', function (Blueprint $table) {
            $table->dropColumn(['instructor_note', 'given_at']);
        });

        DB::statement("ALTER TABLE free_session_requests MODIFY COLUMN status ENUM('pending','scheduled','cancelled') NOT NULL DEFAULT 'pending'");
    }
};
