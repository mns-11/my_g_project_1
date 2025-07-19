<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class College extends Model
{
    protected $fillable = [
        'name',
        'location',
        'phone',
        'email'
    ];

    public function majors(): HasMany
    {
        return $this->hasMany(Major::class);
    }

    public function academicYearCourseHallMajorUsers()
    {
        return $this->belongsToMany(
            AcademicYear::class,
            'academic_years_colleges_courses_halls_majors_users'
        )->using(AcademicYearCollegeCourseHallMajorUser::class)
            ->withPivot(['course_id', 'hall_id', 'major_id', 'user_id', 'type']);
    }
}
