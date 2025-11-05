<?php

namespace DataSource\Entities\Classroom;

use Illuminate\Database\Eloquent\Model;

class ClassSessionType extends Model
{
    protected $fillable = [
        'name',
        'price',
        'teacher_payout',
        'organization_id',
    ];

    public function scopeInOrganization($query, int $organizationId)
    {
        return $query->where('organization_id', $organizationId);
    }
}


