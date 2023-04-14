<?php

namespace DataSource\Entities\Partner;

use Illuminate\Database\Eloquent\Model;
use DataSource\Entities\Taxonomy\Taxonomy;

class Partner extends Model
{
    protected $table = 'partners';
    protected $fillable = [
        'name',
        'is_active'
    ];

    public function taxonomies()
    {
        return $this->belongsToMany(Taxonomy::class, 'partner_taxonomies', 'partner_id', 'taxonomy_id');
    }
}
