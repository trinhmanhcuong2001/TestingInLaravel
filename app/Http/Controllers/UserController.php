<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            [
                "name" => "Cường",
            ],
            [
                "name" => "Huy"
            ]
        ];
        if (is_array($data)) {
            $string = "";
            foreach ($data as $user) {
                $string .= $user['name'];
            }
            return $string;
        }
        return "Đây không phải một mảng dữ liệu";
    }
}
