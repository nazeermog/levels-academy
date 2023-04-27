<?php

namespace DataSource\Entities\Practice;

use DataSource\Entities\BaseModel;

/**
 * @property int $id
 * @property int $practice_id
 * @property int $seconds_speed
 * @property int $card_number
 * @property int $range_number_to
 * @property string $title
 * @property boolean $is_active
 */
class PracticeType extends BaseModel
{

    protected $table = 'practice_types';
    protected $translatedAttributes = ['title'];
    public $translationForeignKey = 'practice_type_id';
    protected $fillable = [
        'seconds_speed',
        'practice_id',
        'card_number',
        'range_number_from',
        'range_number_to',
        'is_active'
    ];

    public function practice()
    {
        return $this->hasOne(Practice::class, 'id', 'practice_id');
    }
}
