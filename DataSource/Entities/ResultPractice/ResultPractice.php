<?php

namespace DataSource\Entities\ResultPractice;

use DataSource\Entities\BaseModel;
use DataSource\Entities\PracticeType\PracticeType;
use DataSource\Entities\Student\Student;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $student_id
 * @property int $practice_id
 * @property int $result_student
 * @property int $result_true
 * @property string $level_title
 * @property boolean $is_true
 */
class ResultPractice extends Model
{
    protected $table = 'result_practices';
    protected $fillable = [
        'student_id',
        'practice_id',
        'result_student',
        'result_true',
        'level_title',
        'is_true',
    ];

    public function student()
    {
        return $this->hasOne(Student::class, 'id', 'student_id');
    }

    public function practice()
    {
        return $this->hasOne(PracticeType::class, 'id', 'practice_id');
    }

    public function resultsType()
    {
        return $this->hasOne(ResultPracticeType::class, 'id', 'practice_id');
    }

}
