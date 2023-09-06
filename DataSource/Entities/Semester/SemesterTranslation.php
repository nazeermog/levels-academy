<?php

namespace DataSource\Entities\Semester;

use Illuminate\Database\Eloquent\Model;

class SemesterTranslation extends Model
{
  protected $fillable = [
    'title',
    'desc',
  ];
}
