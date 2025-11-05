<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::table('class_session_types', function (Blueprint $table) {
            $table->decimal('teacher_payout', 10, 2)->default(0)->after('price');
        });
    }

    public function down()
    {
        Schema::table('class_session_types', function (Blueprint $table) {
            $table->dropColumn('teacher_payout');
        });
    }
};

?>


