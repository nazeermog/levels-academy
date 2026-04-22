<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'first_name' => 'admin',
                'last_name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('123456789'),
                'role' => 'super_admin'
            ],
        ]);
        DB::table('users')->insert([
            [
                'first_name' => 'student',
                'last_name' => 'student',
                'email' => 'student@student.com',
                'password' => Hash::make('123456789'),
                'role' => 'student'
            ],
        ]);
        DB::table('users')->insert([
            [
                'first_name' => 'instructor',
                'last_name' => 'instructor',
                'email' => 'instructor@instructor.com',
                'password' => Hash::make('123456789'),
                'role' => 'instructor'
            ],
        ]);
        DB::table('users')->insert([
            [
                'first_name' => 'student2',
                'last_name' => 'student2',
                'email' => 'student2@student.com',
                'password' => Hash::make('123456789'),
                'role' => 'student'
            ],
        ]);

        DB::table('students')->insert([
            [
                'user_id' => 2,
                'first_name' => 'student',
                'last_name' => 'student',
                'country' => 'Egypt',
                'city' => 'Cairo',
            ],
        ]);
        DB::table('instructors')->insert([
            [
                'user_id' => 3,
                'first_name' => 'instructor',
                'last_name' => 'instructor',
            ],
        ]);
        DB::table('instructor_translations')->insert([
            [
                'spec' => 'اختصاص ويب',
                'about' => 'خبرة 10 سنين',
                'country' => 'سوريا',
                'instructor_id' => 3,
                'locale' => 'ar',
            ],
            [
                'spec' => 'Web specialty',
                'about' => '10 years experience',
                'country' => 'syria',
                'instructor_id' => 3,
                'locale' => 'en',
            ],
            [
                'spec' => 'Web-Spezialität',
                'about' => '10 Jahre',
                'country' => 'syria',
                'instructor_id' => 3,
                'locale' => 'de',
            ],
        ]);
        DB::table('students')->insert([
            [
                'user_id' => 4,
                'first_name' => 'student2',
                'last_name' => 'student2',
                'country' => 'Egypt',
                'city' => 'Cairo',
            ],
        ]);
    }
}
