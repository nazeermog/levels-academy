<?php

namespace Modules\DataResource\Entities\Taxonomy;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\DataResource\Entities\Partner\Partner;


class Taxonomy extends Model
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
}
