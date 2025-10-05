<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use DataSource\Entities\User\User;
use DataSource\Entities\Organization\Organization;

class OrganizationAdminsSeeder extends Seeder
{
    public function run()
    {
        $yasmine = Organization::where('subdomain', 'yasmine')->first();
        $woderhafen = Organization::where('subdomain', 'woderhafen')->first();

        if ($yasmine) {
            User::updateOrCreate(
                ['email' => 'admin@yasmine.com'],
                [
                    'first_name' => 'Yasmine',
                    'last_name' => 'Admin',
                    'password' => Hash::make('123456789'),
                    'role' => 'admin',
                    'organization_id' => $yasmine->id,
                ]
            );
        }

        if ($woderhafen) {
            User::updateOrCreate(
                ['email' => 'admin@woderhafen.com'],
                [
                    'first_name' => 'Woderhafen',
                    'last_name' => 'Admin',
                    'password' => Hash::make('123456789'),
                    'role' => 'admin',
                    'organization_id' => $woderhafen->id,
                ]
            );
        }
    }
}


