<?php

namespace Tests\Feature\Courses;

use App\Models\Course;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_course()
    {
        $data = $this->validData();

        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('/courses', $data)
            ->assertRedirect('/courses');

        $this->assertDatabaseHas('courses', $data);
    }

    public function test_admin_can_update_course()
    {
        $data = $this->validData();

        $course = Course::factory()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->patch('/courses/'. $course->id, $data)
            ->assertRedirect('/courses');

        $this->assertDatabaseHas('courses', $data);
    }

    public function test_admin_can_delete_course()
    {
        $course = Course::factory()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->delete('/courses/' . $course->id)
            ->assertRedirect('/courses');

        $this->assertDatabaseMissing('courses', $course->toArray());
    }

    public function test_user_without_permissions_cant_manage_course()
    {
        $data = $this->validData();

        $guest = User::factory()->guest()->create();

        $this->actingAs($guest)
            ->post('/courses', $data)
            ->assertForbidden();

        $this->assertDatabaseMissing('courses', $data);
    }

    private function validData(): array
    {
        return [
            'title' => 'Mathematics'
        ];
    }
}
