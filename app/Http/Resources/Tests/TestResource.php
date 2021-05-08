<?php

namespace App\Http\Resources\Tests;

use App\Http\Resources\Classrooms\ClassroomResource;
use App\Http\Resources\Courses\CourseResource;
use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TestResource extends JsonResource
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
            'description' => $this->description,
            'passed_at' => $this->passed_at->format('Y-m-d'),
            'teacher' => new UserResource($this->teacher),
            'course' => new CourseResource($this->course),
            'classroom' => new ClassroomResource($this->classroom)
        ];
    }
}
