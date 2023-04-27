<?php

namespace DataSource\Entities\StudentActivity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentActivity extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\StudentActivity\Database\factories\StudentActivityFactory::new();
    }
}
