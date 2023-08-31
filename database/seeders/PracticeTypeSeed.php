<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
                'photo' => storeImage(public_path('images/paths/abacus.jpg'), 'public/practice_type_images'),
            ],
            [
                'blade_name' => 'numbers_sum',
                'is_active' => 1,
                'photo' => storeImage(public_path('images/paths/number_sum.jpg'), 'public/practice_type_images'),
            ],
            [
                'blade_name' => 'math_games',
                'is_active' => 1,
                'photo' => storeImage(public_path('images/paths/numbers.jpg'), 'public/practice_type_images'),
            ],
            [
                'blade_name' => 'math_games2',
                'is_active' => 1,
                'photo' => storeImage(public_path('images/paths/numbers.jpg'), 'public/practice_type_images'),
            ],
        ]);
        DB::table('practice_type_translations')->insert([
            [
                'practice_id' => 1,
                'title' => 'abacus',
                'about' => 'Interactive Learning through Virtual Abacus Manipulation',
                'locale' => 'en',
            ],
            [
                'practice_id' => 1,
                'title' => 'العداد',
                'about' => 'التعلم التفاعلي من خلال التلاعب الافتراضي بالعداد',
                'locale' => 'ar',
            ],
             [
                'practice_id' => 1,
                'title' => 'Abakus',
                'about' => 'Interaktives Lernen durch virtuelle Abakus-Manipulation',
                'locale' => 'de',
            ],
            [
                'practice_id' => 2,
                'title' => 'Numbers Sum',
                'locale' => 'en',
                'about' => 'Practice and Improve Addition Skills with Number Sum Challenges',

            ],
            [
                'practice_id' => 2,
                'title' => 'جمع الأرقام',
                'about' => 'ممارسة وتحسين مهارات الجمع مع تحديات العداد',
                'locale' => 'ar',
            ],
            [
                'practice_id' => 2,
                'title' => 'Zahlensumme',
                'about' => 'Üben und verbessern Sie Ihre Additionsfähigkeiten mit Zahlensummenaufgaben',
                'locale' => 'de',
            ],
            [
                'practice_id' => 3,
                'title' => 'math games',
                'locale' => 'en',
                'about' => 'Practice and Improve Addition Skills with math games Challenges',

            ],
            [
                'practice_id' => 3,
                'title' => 'جمع الأرقام',
                'about' => 'ممارسة وتحسين مهارات الجمع مع العاب الرياضيات',
                'locale' => 'ar',
            ],
            [
                'practice_id' => 3,
                'title' => 'Zahlensumme',
                'about' => 'Üben und verbessern Sie Ihre Additionsfähigkeiten mit Zahlensummenaufgaben',
                'locale' => 'de',
            ],
            [
                'practice_id' => 4,
                'title' => 'math games 2',
                'locale' => 'en',
                'about' => 'Practice and Improve Addition Skills with math games Challenges',

            ],
            [
                'practice_id' => 4,
                'title' => '2 جمع الأرقام',
                'about' => 'ممارسة وتحسين مهارات الجمع مع العاب الرياضيات',
                'locale' => 'ar',
            ],
            [
                'practice_id' => 4,
                'title' => ' Zahlensumme 2',
                'about' => 'Üben und verbessern Sie Ihre Additionsfähigkeiten mit Zahlensummenaufgaben',
                'locale' => 'de',
            ],
        ]);
    }
}
function storeImage($filePath, $storageDirectory)
{
    $imagePath = Storage::putFile($storageDirectory, new \Illuminate\Http\File($filePath));
    return Storage::url($imagePath);
}
