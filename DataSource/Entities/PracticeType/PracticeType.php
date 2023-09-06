<?php

namespace DataSource\Entities\PracticeType;

use DataSource\Entities\BaseModel;
use DataSource\Entities\Course\CourseStep;
use DataSource\Entities\PracticeType\PracticeTypeDetail;

/**
 * @property int $id
 * @property string $title
 * @property boolean $is_active
 */
class PracticeType extends BaseModel
{
    protected $table = 'practice_types';
    protected $translatedAttributes = ['title','about'];
    public $translationForeignKey = 'practice_id';
    protected $fillable = ['is_active','photo'];

    public function levels()
    {
        return $this->hasMany(PracticeTypeDetail::class, 'practice_id');
    }
    public function courseStep()
    {
        return $this->hasOne(CourseStep::class,'stepable_id');
    }
}

