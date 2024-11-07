<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteTaskTest extends TestCase
{
    use RefreshDatabase;

    use RefreshDatabase;

    protected $adminUser;
    protected function setUp(): void
    {
        parent::setUp();

        // Tạo người dùng với vai trò admin và user
        $this->adminUser = User::factory()->create(['role' => 'admin']);
    }
    /**
     * A basic feature test example.
     */
    public function test_user_can_delete_task_if_task_exists(): void
    {
        $task = Task::factory(['user_id' => $this->adminUser->id])->create();

        $response = $this->actingAs($this->adminUser)->deleteJson(route('tasks.destroy', $task->id));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('tasks', $task->toArray());
    }

    public function test_user_can_not_update_if_task_does_not_exist(): void
    {
        $taskId = -1;

        $response = $this->actingAs($this->adminUser)->deleteJson(route('tasks.destroy', $taskId));

        $response->assertStatus(404);

        $response->assertJson([
            'error' => 'Không tìm thấy bản ghi nào'
        ]);
    }
}
