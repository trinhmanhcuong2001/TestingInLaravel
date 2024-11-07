<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTaskTest extends TestCase
{
    use RefreshDatabase;
    protected $adminUser;
    protected $editorUser;
    protected $regularUser;
    protected $task;
    protected function setUp(): void
    {
        parent::setUp();

        // Tạo người dùng với vai trò admin và user
        $this->adminUser = User::factory()->create(['role' => 'admin']);
        $this->editorUser = User::factory()->create(['role' => 'editor']);
        $this->regularUser = User::factory()->create(['role' => 'user']);
    }
    /**
     * A basic feature test example.
     */
    public function test_user_can_create_task_if_data_valid(): void
    {
        $data = [
            'title' => 'Title 1',
            'description' => 'Description 1',
            'completed' => 'Chưa hoàn thành'
        ];
        $count = Task::count();
        $response = $this->actingAs($this->adminUser)->postJson(route('tasks.store'),  $data);

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

        $response = $this->actingAs($this->adminUser)->postJson(route('tasks.store'),  $data);

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
