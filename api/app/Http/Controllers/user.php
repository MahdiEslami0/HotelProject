<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class user extends ApiController
{
    public function show()
    {
        $user = ModelsUser::orderby('id', 'DESC')->get();
        return $this->successResponse([
            'user' =>  $user,
        ], 201);
    }
    public function showbyid($user)
    {
        $user = ModelsUser::where('id', $user)->first();
        return $this->successResponse([
            'user' =>  $user,
        ], 201);
    }
    public function edit(Request $request, $user)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'role' => 'required|max:2500',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }
        ModelsUser::where('id', $user)->update([
            'email' => $request->email,
            'role' => $request->role,
        ]);
    }
    public function rolecheck()
    {
        if (auth()->guard('api')->user()->role == 2) {
            return   [
                'admin' => true,
            ];
        } else {
            return   [
                'admin' => false,
            ];
        }
    }
}
