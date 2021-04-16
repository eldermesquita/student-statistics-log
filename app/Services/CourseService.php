<?php

namespace App\Services;

use App\Http\Requests\Courses\CreateRequest;
use App\Http\Requests\Courses\UpdateRequest;
use App\Models\Course;

class CourseService
{
    public function create(CreateRequest $request): Course
    {
        $course = Course::create([
            'title' => $request['title']
        ]);

        $course->teachers()->sync($request['teachers']);

        return $course;
    }

    public function edit(int $id, UpdateRequest $request): void
    {
        $course = $this->getCourse($id);
        $course->update([
            'title' => $request['title']
        ]);
        $course->teachers()->sync($request['teachers']);
    }

    public function remove(int $id)
    {
        $course = $this->getCourse($id);
        $course->delete();
    }

    public function getCourse(int $id): Course {
        return Course::findOrFail($id);
    }
}
