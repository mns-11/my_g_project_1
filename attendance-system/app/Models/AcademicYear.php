<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $fillable = ['name', 'start_date', 'end_date'];

    public function collegeCourseHallMajorUsers()
    {
        return $this->belongsToMany(College::class, 'academic_years_colleges_courses_halls_majors_users')
            ->using(AcademicYearCollegeCourseHallMajorUser::class)
            ->withPivot(['course_id', 'hall_id', 'major_id', 'user_id', 'type']);
    }
}
