<?php

namespace DataSource\Entities\Organization;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'subdomain',
        'theme_css',
        'is_active',
    ];
}


