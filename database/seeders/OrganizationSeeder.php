<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DataSource\Entities\Organization\Organization;

class OrganizationSeeder extends Seeder
{
    public function run()
    {
        Organization::updateOrCreate(
            ['subdomain' => 'yasmine'],
            [
                'name' => 'Yasmine',
                'theme_css' => 'css/yasmine.css',
                'is_active' => true,
            ]
        );

        Organization::updateOrCreate(
            ['subdomain' => 'woderhafen'],
            [
                'name' => 'Woderhafen',
                'theme_css' => 'css/woderhafen.css',
                'is_active' => true,
            ]
        );
    }
}


