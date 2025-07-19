<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'type' => __('main.' . $this->type->getName()),
            'term' => __('main.' . strtolower($this->term->getName())),
            'is_blocked' => $this->is_blocked,
            'hours' => $this->hours,
            'college' => $this->major->college->name,
            'major' => $this->major->name,
            'level' => $this->level?->name,
            'teachers' => $this->teachers()
        ];
    }

    private function teachers()
    {
        return $this->academicYearCollegeHallMajorUser->map(function ($q) {
            return $q->pivot->user->name;
        });
    }
}
