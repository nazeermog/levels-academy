<?php

namespace DataSource\Entities\Link;

use Illuminate\Database\Eloquent\Model;

/**
 * A titled URL attached to a course step (stepable_type "Links").
 * Created inline in the course builder — no separate CRUD.
 */
class Link extends Model
{
    protected $table = 'links';

    protected $fillable = [
        'title',
        'url',
    ];
}
