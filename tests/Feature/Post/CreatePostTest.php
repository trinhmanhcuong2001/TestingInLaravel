<?php

namespace Tests\Feature\Post;

use Tests\TestCase;
use App\Jobs\SendMailCreatePost;
use App\Mail\PostCreateMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_user_can_create_post(): void
    {
        Queue::fake();

        Mail::fake();

        $postData = [
            'title' => 'Bài test',
            'content' => 'Đây là bài test test test'
        ];

        $response = $this->postJson(route("posts.create"), $postData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => 'Tạo bài đăng thành công!',
            ]);

        $response->assertJsonMissingValidationErrors(['title', 'content']);

        $this->assertDatabaseHas('posts', $postData);

        Queue::assertPushed(SendMailCreatePost::class, function ($job) use ($postData) {
            $job->handle();

            return $job->post->title === $postData['title'];
        });

        Mail::assertSent(PostCreateMail::class, 1);
    }

    public function test_user_can_not_create_post_if_data_missing()
    {
        Queue::fake();

        Mail::fake();

        $postData = [
            'title' => 'Bài test',
            'content' => ''
        ];

        $response = $this->postJson(route("posts.create"), $postData);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(["content"]);

        Queue::assertNotPushed(SendMailCreatePost::class);

        Mail::assertNotQueued(PostCreateMail::class);
    }
}
