<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Database\Seeders\ParenttSeed;
use Database\Seeders\PracticeTypeSeed;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // UserSeed::class,
            // PracticeTypeSeed::class,
            // ParenttSeed::class,
           //OrganizationSeeder::class,
           //OrganizationAdminsSeeder::class,
            OrganizationMembersSeeder::class,

        ]);
    }
}
