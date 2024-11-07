<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteTaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_user_can_delete_task_if_task_exists(): void
    {
        $task = Task::factory()->create();

        $response = $this->delete(route('tasks.destroy', $task->id));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('tasks', $task->toArray());
    }

    public function test_user_can_not_update_if_task_does_not_exist(): void
    {
        $taskId = -1;

        $response = $this->delete(route('tasks.destroy', $taskId));

        $response->assertStatus(404);

        $response->assertJson([
            'error' => 'Không tìm thấy bản ghi nào'
        ]);
    }
}
