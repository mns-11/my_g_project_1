<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'course' =>
                        [
                            'course_id' => $this->course->id,
                            'course_name' => $this->course->name,
                            'course_type' => __('main.' . $this->course->type->getName())
                        ],
            'status' => __('main.' . $this->status->getName()),
            'lecture_id' => $this->lecture_id,
            'lecture_datetime' => $this->when(!empty($this->lecture?->datetime), $this->lecture->datetime->format('Y-m-d H:i:s')),
            'lecture_duration' => $this->lecture?->duration,
            'excuse_type' => $this->excuse_type,
            'is_transformed' => $this->is_transformed,
            'is_accepted' => $this->is_approved,
            'reject_reason' => $this->reject_reason,
            'document_path' => $this->when(!empty($this->document_path), Storage::url($this->document_path), null)
        ];
    }
}
