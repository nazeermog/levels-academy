<?php

namespace DataSource\Repositories\DB\StudentScore\Instructor;


use DataSource\Entities\User\User;
use Illuminate\Support\Facades\Storage;
use DataSource\Entities\Instructor\Instructor;
use DataSource\Entities\StudentScore\StudentScore;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminStudentScoreRepository
{
    use AdminCRUDGenericRepository;

    protected $model = StudentScore::class;

    public static function list()
    {
        return StudentScore::all();
    }
    public static function TotalCoins()
    {
        $studentCoins=[];
        $StudentScores=StudentScore::all();
        foreach($StudentScores as $studentScore){
            $coins = StudentScore::where('student_id', $studentScore->student_id)->sum('coin');
            $studentCoins[$studentScore->student_id]=$coins;
        }
        return $studentCoins;
    }
   
    

}