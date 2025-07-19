<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    protected $fillable = ['name'];

    public function students(): HasMany
    {
        return $this->hasMany(User::class)->role('student');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'level_id');
    }
}
