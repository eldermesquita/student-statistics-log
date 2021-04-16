<?php

namespace App\Http\Resources\Courses;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'title' => $this->title,
            'teachers_count' => $this->teachers->count(),
            'tests_count' => $this->tests->count(),
        ];
    }
}
