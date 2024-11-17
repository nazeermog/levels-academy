<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_scores', function (Blueprint $table) {
            $table->string('type')->nullable()->after('practice_id');
        });
    }

    public function down()
    {
        Schema::table('student_scores', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
