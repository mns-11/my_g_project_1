<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    protected $fillable = ['name', 'location'];

    public function academicYearCourseCollegeMajorUsers()
    {
        return $this->belongsToMany(
            AcademicYear::class,
            'academic_years_colleges_courses_halls_majors_users'
        )->using(AcademicYearCollegeCourseHallMajorUser::class)
            ->withPivot(['course_id', 'college_id', 'major_id', 'user_id', 'type']);
    }
}
