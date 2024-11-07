<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthControllerApi extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = request(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'authToken' => $token
            ], 200);
        } else {
            return response()->json([
                'message' => 'Thông tin sai'
            ], 401);
        }
    }
}
