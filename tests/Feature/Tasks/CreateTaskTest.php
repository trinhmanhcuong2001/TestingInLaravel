<?php

namespace Tests\Feature\Tasks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateTaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function routeCreate()
    {
        return route('task.create');
    }

    public function routePostCreate()
    {
        return route('task.store');
    }
    public function test_user_can_see_create_task_view()
    {
        $response = $this->get($this->routeCreate());

        $response->assertStatus(Response::HTTP_OK);

        $response->assertViewIs('tasks.create');

        $response->assertSee('Create Task');
    }

    public function test_user_can_create_task_if_data_is_not_missing()
    {
        $dataCeate = [
            'title' => 'Backend',
            'description' => 'Xây dựng logic',
            'completed' => 'Chưa hoàn thành'
        ];

        $response = $this->post($this->routePostCreate());

        $response->assertStatus(302);
    }
}
