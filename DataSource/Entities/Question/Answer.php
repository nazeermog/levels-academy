<?php

namespace DataSource\Entities\Question;

use Illuminate\Database\Eloquent\Model;


class Answer extends Model
{
    protected $table = 'answer_questions';
    public $translationForeignKey = 'answer_question_id';
    protected $translatedAttributes = [
        'answer'
    ];
    protected $fillable = [ 'question_id', 'is_correct'];
    protected $casts = ['answer' => 'array'];

}
