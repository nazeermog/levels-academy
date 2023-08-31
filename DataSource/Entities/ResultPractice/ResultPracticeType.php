<?php

namespace DataSource\Entities\ResultPractice;

use DataSource\Entities\BaseModel;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int $id
 * @property int $result_practice_id
 * @property int $seconds_speed
 * @property int $card_number
 * @property int $range_number_from
 * @property int $range_number_to
 */
class ResultPracticeType extends Model
{
    protected $table = 'result_practice_types';
    protected $fillable = [
        'result_practice_id',
        'seconds_speed',
        'card_number',
        'range_number_from',
        'range_number_to',
        'timer',
    ];

    public function result()
    {
        return $this->hasOne(ResultPractice::class, 'id', 'result_practice_id');
    }
}
