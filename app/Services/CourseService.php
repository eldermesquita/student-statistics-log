<?php

namespace App\Services;

use App\Http\Requests\CourseRequest;
use App\Models\Course;

class CourseService
{
    public function create(CourseRequest $request): Course
    {
        return Course::create([
            'title' => $request['title']
        ]);
    }

    public function edit(int $id, CourseRequest $request): void
    {
        $course = $this->getCourse($id);
        $course->update([
            'title' => $request['title']
        ]);
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
