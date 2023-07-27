<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PracticeTypeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('practice_types')->insert([
            [
                'blade_name' => 'abacus',
                'is_active' => 1,
            ],
            [
                'blade_name' => 'numbers_sum',
                'is_active' => 1,
            ],
        ]);
        DB::table('practice_type_translations')->insert([
            [
                'practice_id' => 1,
                'title' => 'abacus',
                'locale' => 'en',
            ],
            [
                'practice_id' => 1,
                'title' => 'العداد',
                'locale' => 'ar',
            ],
            [
                'practice_id' => 2,
                'title' => 'Numbers Sum',
                'locale' => 'en',
            ],
            [
                'practice_id' => 2,
                'title' => 'جمع الأرقام',
                'locale' => 'ar',
            ],
        ]);
    }
}
