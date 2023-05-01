<?php

namespace DataSource\Entities\PracticeType;

use DataSource\Entities\BaseModel;

/**
 * @property int $id
 * @property string $title
 * @property boolean $is_active
 */
class PracticeType extends BaseModel
{
    protected $table = 'practice_types';
    protected $translatedAttributes = ['title'];
    public $translationForeignKey = 'practice_id';
    protected $fillable = ['is_active'];

    public function levels()
    {
        return $this->hasMany(PracticeTypeDetail::class, 'practice_id');
    }
}

