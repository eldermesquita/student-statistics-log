<?php

namespace App\Http\Resources\Classrooms;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassroomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'postfix' => $this->postfix,
            'full_name' => $this->full_name
        ];
    }
}
