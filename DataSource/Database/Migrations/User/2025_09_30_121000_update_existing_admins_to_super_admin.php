<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        // Promote admins without organization to super_admin
        DB::table('users')
            ->where('role', 'admin')
            ->whereNull('organization_id')
            ->update(['role' => 'super_admin']);
    }

    public function down()
    {
        // No reliable automatic rollback; leave as-is
    }
};


