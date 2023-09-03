<?php

namespace DataSource\Entities\Taxonomy;

use DataSource\Entities\BaseModel;
use DataSource\Entities\Course\Course;
use Illuminate\Database\Eloquent\Model;
use DataSource\Entities\Partner\Partner;
use Astrotomic\Translatable\Translatable;


class Taxonomy extends BaseModel
{
    use Translatable;

    protected $table = 'taxonomies';
    public $translationForeignKey = 'taxonomy_id';
    protected $translatedAttributes = [
        'title',
        'desc'
    ];
    protected $fillable = [
        'type',
        'parent_id',
        'is_active'
    ];

    public function partners()
    {
        return $this->belongsToMany(Partner::class, 'partner_taxonomies', 'taxonomy_id', 'partner_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
