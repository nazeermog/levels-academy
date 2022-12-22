<?php

namespace Modules\Question\Entities;

use Illuminate\Database\Eloquent\Model;


class Question extends Model
{


    protected $fillable = ['point','question_text','practice_id','question_type'];

}
