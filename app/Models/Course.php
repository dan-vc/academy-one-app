<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course_code',
        'name',
        'teacher_id',
        'credits',
        'max_capacity',
        'status',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
