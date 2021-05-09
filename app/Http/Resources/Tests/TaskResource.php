<?php

namespace App\Http\Resources\Tests;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'min_score' => $this->min_score,
            'max_score' => $this->max_score,
            'grades' => GradeResource::collection($this->grades)
        ];
    }
}
