<?php

namespace Tests\Feature\Tests;

use App\Models\Classroom;
use App\Models\Course;
use App\Models\Test;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageTest extends TestCase
{

    use RefreshDatabase;

    public function test_admin_can_create_test()
    {
        $data = array_merge(
            [
                'teacher' => User::factory()->teacher()->create()->id,
                'course' => Course::factory()->create()->id,
                'classroom' => Classroom::factory()->create()->id
            ],
            $this->validData()
        );

        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('/tests', $data)
            ->assertRedirect('/tests');

        $this->assertDatabaseHas('tests', [
            'title' => 'Bar'
        ]);
    }

    public function test_admin_can_update_test()
    {
        $updData = $this->validData();

        $test = Test::factory()->create();

        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->patch('/tests/' . $test->id, $updData)
            ->assertRedirect('/tests');

        $this->assertDatabaseHas('tests', $updData);
    }

    public function test_admin_can_delete_test()
    {
        $test = Test::factory()->create();

        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->delete('/tests/' . $test->id)
            ->assertRedirect('/tests');

        $this->assertDatabaseMissing('tests', $test->toArray());
    }

    public function test_user_without_permissions_cant_manage_test()
    {
        $test = Test::factory()->create();
        $admin = User::factory()->guest()->create();

        $this->actingAs($admin)
            ->post('/tests', [])
            ->assertForbidden();

        $this->actingAs($admin)
            ->patch('/tests/' . $test->id, [])
            ->assertForbidden();

        $this->actingAs($admin)
            ->delete('/tests/' . $test->id, [])
            ->assertForbidden();
    }

    private function validData(): array
    {
        return [
            'title' => 'Bar',
            'description' => null,
            'passed_at' => '2018-07-22'
        ];
    }
}
