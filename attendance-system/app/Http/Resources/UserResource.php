<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'birthdate' => $this->birthdate,
            'gender' => $this->when(!empty($this->gender),__('main.' . lcfirst($this->gender)),null),
            'major' => ['name' => $this->major->name, 'college' => $this->major->college->name],
            'level' => $this->level?->name,
        ];
    }
}
