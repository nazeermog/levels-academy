<?php

namespace DataSource\Entities\Guest;

use Illuminate\Database\Eloquent\Model;
use DataSource\Entities\Taxonomy\Taxonomy;

class Guest extends Model
{
    protected $table = 'Guests';
    protected $fillable = [
        'name',
        'is_active'
    ];

    public function taxonomies()
    {
        return $this->belongsToMany(Taxonomy::class, 'Guest_taxonomies', 'Guest_id', 'taxonomy_id');
    }
}
