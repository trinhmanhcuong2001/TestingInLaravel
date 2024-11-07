<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetListTaskTest extends TestCase
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
    public function test_user_can_get_list_task_if_user_sufficient_permissions(): void
    {
        $response = $this->actingAs($this->adminUser)->getJson(route("tasks.index"));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'title',
                    'description',
                    'completed',
                ]
            ]
        ]);
    }

    public function test_user_can_not_get_list_if_user_have_not_sufficient_permissions(): void
    {
        $response = $this->actingAs($this->regularUser)->get(route("tasks.index"));

        $response->assertStatus(403);

        $response->assertJson(['error' => 'Không đủ quyền để thực hiện']);
    }

    public function test_user_can_not_get_list_if_user_is_not_logged_in(): void
    {
        $response = $this->getJson(route("tasks.index"));

        $response->assertStatus(401);

        $response->assertJson(['message' => 'Bạn cần đăng nhập để thực hiện']);
    }
}
