<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Major extends Model
{
    protected $fillable = [
        'name',
        'college_id',
        'location',
        'phone',
        'email',
        'num_levels'
    ];

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function academicYearCourseCollegeHallUsers()
    {
        return $this->belongsToMany(
            AcademicYear::class,
            'academic_years_colleges_courses_halls_majors_users'
        )->using(AcademicYearCollegeCourseHallMajorUser::class)
            ->withPivot(['course_id', 'hall_id', 'college_id', 'user_id', 'type']);
    }
}
