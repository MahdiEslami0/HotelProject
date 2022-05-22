<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    public function get_user_info()
    {
        return   [
            'user' => auth()->guard('api')->user(),
        ];
    }
    public function  get_user_logout()
    {
        auth()->guard('api')->user()->tokens()->delete();
        return $this->successResponse('logged out', 200);
    }
}
