<?php

namespace App\Models;

use App\Enums\CourseType;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AcademicYearCollegeCourseHallMajorUser extends Pivot
{
    protected $table = 'academic_years_colleges_courses_halls_majors_users';

    protected $fillable = [
        'type',
        'user_id',
        'major_id',
        'college_id',
        'course_id',
        'hall_id',
        'academic_year_id',
    ];
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTypeAttribute($value): CourseType
    {
        return CourseType::from($value);
    }
}
