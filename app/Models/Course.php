<?php

namespace App\Models;

use Attribute;
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

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Esto crea un atributo virtual: $course->occupation_rate
    public function occupationRate()
    {
        // Evitar división por cero
        if ($this->max_capacity == 0) return 0;

        // Nota: necesitamos haber cargado 'total_students' con withCount en el controlador
        // Si no se cargó, usamos la relación (menos eficiente pero seguro)
        $count = $this->total_students ?? $this->enrollments()->count();

        return round(($count / $this->max_capacity) * 100, 2);
    }

    public function approvalRate()
    {
        $total = $this->total_students ?? $this->enrollments()->count();

        if ($total == 0) return 0;

        // Usamos el conteo que trajimos con withCount
        $approved = $this->approved_students ?? $this->enrollments()->where('status', 'approved')->count();

        return round(($approved / $total) * 100, 2);
    }
}
