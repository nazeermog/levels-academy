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
                'role' => 'admin'
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
        DB::table('students')->insert([
            [
                'user_id' => 2,
                'first_name' => 'student',
                'last_name' => 'student',
                'country' => 'Egypt',
                'city' => 'Cairo',
            ],
        ]);
        // DB::table('instructors')->insert([
        //     [
        //         'user_id' => 3,
        //         'first_name' => 'first',
        //         'last_name' => 'teacher',
        //         'country' => 'Egypt',
        //         'city' => 'Cairo',
        //         'spec' => 'Software Engineer and Developer',
        //         'about' => 'first teacher is a software developer. With more than 20 years of software development experience.',

        //     ],
        // ]);
    }
}
