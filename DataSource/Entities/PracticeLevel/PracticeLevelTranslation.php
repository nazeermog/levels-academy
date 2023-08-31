<?php

namespace DataSource\Entities\PracticeLevel;

use Illuminate\Database\Eloquent\Model;

class PracticeLevelTranslation extends Model
{
    protected $fillable = ['title'];
    public $timestamps = false;
}
