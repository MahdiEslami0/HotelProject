<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends ApiController
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'city' => 'required|string|max:100',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }
        category::create([
            'name' => $request->name,
            'city' => $request->city,
        ]);
        return $this->successResponse([
            'message' =>  'Category created',
        ], 201);
    }

    public function show()
    {
        $category = category::orderby('city', 'ASC')->get();
        return $this->successResponse([
            'message' =>  'success',
            'categories' => $category
        ], 200);
    }

    public function show_by_id($id)
    {
        $category = category::where('c_id', $id)->first();
        return $this->successResponse([
            'message' =>  'success',
            'categories' => $category
        ], 200);
    }

    public function edit(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'city' => 'required|string|max:100',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }
        category::where('c_id', $id)->update([
            'name' => $request->name,
            'city' => $request->city,
        ]);
        return $this->successResponse([
            'message' =>  'hotel created',
        ], 201);
    }

    public function delete($id)
    {
        category::where('c_id', $id)->delete();
        return $this->successResponse([
            'message' =>  'hotel created',
        ], 201);
    }
}
