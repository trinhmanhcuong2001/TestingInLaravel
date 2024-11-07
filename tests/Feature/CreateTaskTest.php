<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTaskTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function test_user_can_create_task_if_data_valid(): void
    {
        $data = [
            'title' => 'Title 1',
            'description' => 'Description 1',
            'completed' => 'Chưa hoàn thành'
        ];
        $count = Task::count();
        $response = $this->postJson(route('tasks.store'),  $data);

        $response->assertStatus(201);

        $response->assertJsonFragment($data);

        $response->assertJsonStructure([
            'message',
            'task'
        ]);

        $response->assertJsonMissingValidationErrors(['title', 'description']);

        $this->assertDatabaseHas('tasks', ['title' => $data['title']]);

        $this->assertDatabaseCount('tasks', $count + 1);
    }

    public function test_user_can_not_create_task_if_data_is_not_valid()
    {
        $data = [
            'title' => 'CÔng việc 1',
            'description' => '',
            'completed' => ''
        ];

        $response = $this->postJson(route('tasks.store'),  $data);

        $response->assertStatus(422);

        $response->assertJsonFragment([
            'message' => 'Trường Mô tả không được để trống (and 1 more error)'
        ]);

        $response->assertJsonStructure([
            'message',
            'errors'
        ]);

        $response->assertJsonValidationErrors(['completed', 'description']);
    }
}
