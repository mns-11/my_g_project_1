<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QrCode extends Model
{
    protected $fillable = ['lecture_id', 'image_path'];

    public function lecture(): BelongsTo
    {
        return $this->belongsTo(Lecture::class);
    }
}
