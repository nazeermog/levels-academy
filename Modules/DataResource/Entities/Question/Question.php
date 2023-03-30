<?php

namespace Modules\DataResource\Entities\Question;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;


class Question extends Model
{
    use Translatable;

    protected $table = 'questions';
    public $translationForeignKey = 'question_id';
    protected $translatedAttributes = [
        'question_text'
    ];
    protected $fillable = ['point', 'practice_id', 'question_type'];

}
