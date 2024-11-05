<?php

namespace Tests\Unit;

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

class UserModelTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_get_name_and_email_in_model(): void
    {
        $user = new User(["email" => "example@example.com", "name" => "Hello"]);

        $this->assertEquals("Hello : example@example.com", $user->getNameAndEmail());

        $this->assertIsString($user->getNameAndEmail());
    }

    public function test_return_type_in_controller()
    {
        $response = new UserController();

        $this->assertIsString($response->index());

        $this->assertEquals("CườngHuy", $response->index());
    }
}
