<?php

namespace DataSource\Entities\Course;

use DataSource\Entities\Course\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;

class CoursePath extends Model
{
    use Translatable;

    protected $translatedAttributes = [
        'title',
        'desc',
        'about',
        'benefit',
    ];
    protected $fillable = [
        'course_id',
        'taxonomy_id',
        'photo',
    ];
        public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
