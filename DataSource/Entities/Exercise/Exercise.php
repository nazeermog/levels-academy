<?php

namespace DataSource\Entities\Exercise;

use DataSource\Entities\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exercise extends BaseModel
{
    use HasFactory;

    protected $table = 'exercises';
    public $translationForeignKey = 'exercise_id';
    protected $translatedAttributes = [
        'title',

    ];

    protected $fillable = [
        'practice_id',
        'code',
        'col_count',
        'numbers',
        'quiz_type'
    ];
}
