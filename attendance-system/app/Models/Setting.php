<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
    ];

    protected $casts = [
        'value' => 'json',
    ];

    public static $defaults = [
        'language' => 'ar',
        'theme' => 'light',
        'email_notifications' => 'on',
        'backup_frequency' => 'weekly',
        'block_subject_enabled' => false,
        'specialization' => null,
        'level' => null,
        'subject' => null,
        'attendance_threshold' => 75,
        'late_threshold' => 15,
    ];

    public static function getAllSettings()
    {
        $settings = self::all()->pluck('value', 'key')->toArray();
        return array_merge(self::$defaults, $settings);
    }

    public static function updateSettings(array $data)
    {
        foreach ($data as $key => $value) {
            self::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }

    public static function resetToDefault()
    {
        self::query()->delete();
        return self::$defaults;
    }
}
