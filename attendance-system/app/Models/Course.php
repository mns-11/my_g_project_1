<?php

namespace App\Models;

use App\Enums\AcademicTerm;
use App\Enums\CourseType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    protected $fillable = [
        'name',
        'type',
        'level_id',
        'major_id',
        'college_id',
        'is_blocked',
        'term',
        'hours',
        'code'
    ];

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function getTypeAttribute($value): CourseType
    {
        return CourseType::from($value);
    }

    public function getTermAttribute($value): AcademicTerm
    {
        return AcademicTerm::from($value);
    }

    public function academicYearCollegeHallMajorUser()
    {
        return $this->belongsToMany(
            AcademicYear::class,
            'academic_years_colleges_courses_halls_majors_users'
        )->using(AcademicYearCollegeCourseHallMajorUser::class)
            ->withPivot(['college_id', 'hall_id', 'major_id', 'user_id', 'type']);
    }


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_blocked' => 'boolean',
        ];
    }

}
