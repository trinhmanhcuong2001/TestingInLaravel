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
    protected function setUp(): void
    {
        parent::setUp();

        // Tạo người dùng với vai trò admin và user
        $this->adminUser = User::factory()->create(['role' => 'admin']);
    }
    /**
     * A basic feature test example.
     */
    public function test_user_can_get_list_task(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route("tasks.index"));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data'
        ]);
    }
}
