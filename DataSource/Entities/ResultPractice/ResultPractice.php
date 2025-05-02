<?php

namespace DataSource\Entities\ResultPractice;

use DataSource\Entities\BaseModel;
use Illuminate\Database\Eloquent\Model;
use DataSource\Entities\Student\Student;
use DataSource\Entities\PracticeType\PracticeType;
use DataSource\Entities\PracticeType\PracticeTypeDetail;
use DataSource\Entities\ResultPractice\ResultPracticeType;

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
        return $this->hasOne(Student::class, 'user_id', 'student_id');
    }

    public function practice()
    {
        return $this->hasOne(PracticeType::class, 'id', 'practice_id');
    }
    public function practiceLevel()
    {
        return $this->belongsTo(PracticeTypeDetail::class, 'level_title', 'id');
    }
    
    public function resultsType()
    {
        return $this->hasOne(ResultPracticeType::class);
    }
}
