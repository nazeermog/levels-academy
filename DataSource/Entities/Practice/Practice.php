<?php

namespace DataSource\Entities\Practice;

use DataSource\Entities\BaseModel;

/**
 * @property int $id
 * @property string $title
 * @property boolean $is_active
 */
class Practice extends BaseModel
{
    protected $table = 'practices';
    protected $translatedAttributes = ['title'];
    public $translationForeignKey = 'practice_id';
    protected $fillable = ['is_active'];

    public function levels()
    {
        return $this->hasMany(PracticeType::class, 'practice_id');
    }
}

