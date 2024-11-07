<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_user_can_update_task_if_data_valid(): void
    {
        $task = Task::factory()->create();

        $dataUpdate = [
            'title' => "Update 1",
            'description' => "Update 1 description",
            'completed' => "Chưa hoàn thành"
        ];

        $response = $this->put(route('tasks.update', $task->id), $dataUpdate);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'message' => 'Cập nhật công việc thành công!'
        ]);

        $response->assertJsonStructure([
            'message',
            'task' => [
                'title',
                'description'
            ]

        ]);

        $this->assertDatabaseHas('tasks', ['title' => $dataUpdate['title']]);
    }

    public function test_user_can_not_update_task_if_task_does_not_exist()
    {
        $taskId = -1;
        $dataUpdate = [
            'title' => "Update 1",
            'description' => "Update 1 description",
            'completed' => "Chưa hoàn thành"
        ];
        $response = $this->putJson(route('tasks.update', $taskId), $dataUpdate);

        $response->assertStatus(404);

        $response->assertJson([
            'error' => 'Không tìm thấy bản ghi phù hợp'
        ]);

        $this->assertDatabaseMissing('tasks', ['title' => $dataUpdate['title']]);
    }

    public function test_user_can_not_update_task_if_data_missing()
    {
        $dataUpdate = [
            'title' => 'updatre',
            'description' => '',
        ];

        $task = Task::factory()->create();

        $response = $this->putJson(route('tasks.update', $task->id), $dataUpdate);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors' => ['description', 'completed']
        ]);

        $response->assertJsonFragment([
            'description' => ['Trường Mô tả không được để trống']
        ]);

        $this->assertDatabaseMissing('tasks', ['title' => $dataUpdate['title']]);
    }
}
