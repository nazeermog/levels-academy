<?php

namespace Modules\Question\Entities;

use Illuminate\Database\Eloquent\Model;


class Answer extends Model
{

    protected $table = 'answer_questions';
    protected $fillable = ['answer', 'question_id', 'is_correct'];
    protected $casts = ['answer' => 'array'];

}
