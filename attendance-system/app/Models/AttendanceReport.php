<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceReport extends Model
{
    protected $fillable = [
        'type',
        'college_id',
        'major_id',
        'level_id',
        'user_id',
        'report_data',
        'generated_by',
        'sent_at'
    ];


    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function generatedBy()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'report_data' => 'array',
            'sent_at' => 'datetime'
        ];
    }
}
