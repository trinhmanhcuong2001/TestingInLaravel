<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailCreatePost;
use Exception;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;


class PostController extends Controller
{
    public function store(CreatePostRequest $request)
    {
        try {
            $post = Post::create($request->validated());

            dispatch(new SendMailCreatePost($post));

            return response()->json([
                'success' => 'Tạo bài đăng thành công!',
                'data' => $post
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
