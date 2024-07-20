<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ParenttSeed extends Seeder
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
        'first_name' => 'parent',
        'last_name' => 'parent',
        'email' => 'parent@parent.com',
        'password' => Hash::make('123456789'),
        'role' => 'parentt'
      ],
    ]);
    DB::table('parentts')->insert([
      [
        'user_id' => 5, //<-----------
        'first_name' => 'parent',
        'last_name' => 'parent',
      ],
    ]);
    DB::table('parentt_student')->insert([
      [
        'parentt_id' => 5,
        'student_id' => 2,
      ],
    ]);
    DB::table('parentt_student')->insert([
      [
        'parentt_id' => 5,
        'student_id' => 4,
      ],
    ]);
  }
}
