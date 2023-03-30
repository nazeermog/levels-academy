<?php

namespace Modules\DataResource\Entities\Taxonomy;

use Illuminate\Database\Eloquent\Model;

class TaxonomyTranslation extends Model
{
    protected $fillable = ['title', 'desc'];
}
