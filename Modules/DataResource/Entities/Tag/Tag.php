<?php

namespace Modules\DataResource\Entities\Tag;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Translatable;

    protected $table = 'tags';
    public $translationForeignKey = 'tag_id';
    protected $translatedAttributes = [
        'title'
    ];
    protected $fillable = ['is_active'];

}
