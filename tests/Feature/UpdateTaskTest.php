<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTaskTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $regularUser;
    protected function setUp(): void
    {
        parent::setUp();

        // Tạo người dùng với vai trò admin và user
        $this->adminUser = User::factory()->create(['role' => 'admin']);
        $this->regularUser = User::factory()->create(['role' => 'user']);
    }
    /**
     * A basic feature test example.
     */
    public function test_user_can_update_task_if_data_valid_and_user_logged(): void
    {
        $task = Task::factory()->create();

        $dataUpdate = [
            'title' => "Update 1",
            'description' => "Update 1 description",
            'completed' => "Chưa hoàn thành"
        ];

        $response = $this->actingAs($this->adminUser)->putJson(route('tasks.update', $task->id), $dataUpdate);

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
        $response = $this->actingAs($this->adminUser)->putJson(route('tasks.update', $taskId), $dataUpdate);

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

        $task = Task::factory(['user_id' => $this->adminUser->id])->create();

        $response = $this->actingAs($this->adminUser)->putJson(route('tasks.update', $task->id), $dataUpdate);

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

    public function test_user_can_not_update_if_user_have_not_sufficient_permissions()
    {
        $task = Task::factory()->create();

        $dataUpdate = [
            'title' => "Update 1",
            'description' => "Update 1 description",
            'completed' => "Chưa hoàn thành"
        ];

        $response = $this->actingAs($this->regularUser)->putJson(route('tasks.update', $task->id), $dataUpdate);

        $response->assertStatus(403);

        $response->assertJson(['message' => 'Bạn không có quyền cho hành động này']);
        $this->assertDatabaseMissing('tasks', ['title' => $dataUpdate['title']]);
    }

    public function test_user_can_not_update_if_user_is_not_logged_in()
    {
        $task = Task::factory()->create();

        $dataUpdate = [
            'title' => "Update 1",
            'description' => "Update 1 description",
            'completed' => "Chưa hoàn thành"
        ];

        $response = $this->putJson(route('tasks.update', $task->id), $dataUpdate);

        $response->assertStatus(401);

        $response->assertJson(['message' => 'Bạn cần đăng nhập để thực hiện']);
    }
}
