<?php

namespace Modules\TaxonomyCategory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaxonomyCategory extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\TaxonomyCategory\Database\factories\TaxonomyCategoryFactory::new();
    }
}
