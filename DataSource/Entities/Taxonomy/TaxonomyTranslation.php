<?php

namespace DataSource\Entities\Taxonomy;

use Illuminate\Database\Eloquent\Model;

class TaxonomyTranslation extends Model
{
    protected $fillable = ['title', 'desc'];
    public $timestamps = false;
}
