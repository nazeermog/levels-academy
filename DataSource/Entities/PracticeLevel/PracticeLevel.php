<?php

namespace DataSource\Entities\PracticeLevel;

use DataSource\Entities\BaseModel;
use Astrotomic\Translatable\Translatable;
use DataSource\Entities\PracticeType\PracticeTypeDetail;


class PracticeLevel extends BaseModel
{
    use Translatable;

    protected $table = 'practice_levels';
    public $translationForeignKey = 'practice_level_id';
    protected $translatedAttributes = ['title'];
    protected $fillable = [
        'is_active'
    ];

    public function practiceTypeDetails()
    {
        return $this->belongsToMany(PracticeTypeDetail::class);
    }
}
