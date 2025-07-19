<?php

namespace App\Models;

use App\Enums\AttendanceStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'course_id',
        'user_id',
        'status',
        'is_approved',
        'is_transformed',
        'date',
        'document_path',
        'excuse_type',
        'reject_reason',
        'lecture_id',
        'level_id',
        'mac_address'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lecture(): BelongsTo
    {
        return $this->belongsTo(Lecture::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function getStatusAttribute($value): AttendanceStatus
    {
        return AttendanceStatus::from($value);
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
           'is_approved' => 'boolean',
           'is_transformed' => 'boolean',
        ];
    }
}
