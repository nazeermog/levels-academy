<?php

namespace DataSource\Entities\Absence;

use Illuminate\Database\Eloquent\Model;
use DataSource\Entities\Classroom\ClassSession;

class Absence extends Model
{
    protected $fillable = [
        'class_session_id',
        'student_id',
        'requested_at',
        'status',
        'notes',
    ];

    public function session()
    {
        return $this->belongsTo(ClassSession::class, 'class_session_id');
    }
}

?>


