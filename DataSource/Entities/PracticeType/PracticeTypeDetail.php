<?php

namespace DataSource\Entities\PracticeType;

use DataSource\Entities\BaseModel;
use DataSource\Entities\PracticeType\PracticeType;
use DataSource\Entities\PracticeLevel\PracticeLevel;

/**
 * @property int $id
 * @property int $practice_id
 * @property int $seconds_speed
 * @property int $card_number
 * @property int $range_number_to
 * @property string $title
 * @property boolean $is_active
 */
class PracticeTypeDetail extends BaseModel
{

    protected $table = 'practice_type_details';
    protected $translatedAttributes = ['title'];
    public $translationForeignKey = 'practice_type_id';
    protected $fillable = [
        'seconds_speed',
        'practice_id',
        'card_number',
        'range_number_from',
        'range_number_to',
        'is_active',
        'level_id',
        'col_count',
        'numbers_to_sum',
        'timer',
        'turns',
    ];

    public function practice()
    {
        return $this->hasOne(PracticeType::class, 'id', 'practice_id');
    }
    public function practiceLevel()
    {
        return $this->belongsTo(PracticeLevel::class,'level_id');
    }
}
