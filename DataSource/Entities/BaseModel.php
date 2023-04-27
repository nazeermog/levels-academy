<?php

namespace DataSource\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use Translatable;

    public function getTranslatableAttributes(): array
    {
        if (isset($this->translatedAttributes))
            return $this->translatedAttributes;
        else return [];
    }

}
