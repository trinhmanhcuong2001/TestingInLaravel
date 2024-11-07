<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetListTaskTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_can_get_list_task(): void
    {
        $response = $this->get(route("tasks.index"));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data'
        ]);
    }
}
