<?php

namespace App\Http\Controllers;

use App\Models\hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class HotelController extends ApiController
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:250',
            'category' => 'required|max:100',
            'body' => 'required|string',
            'stars' => 'required',
            'image' => 'required|string|max:300',
            'address' => 'required|string|max:300',
            'capacity' => 'required',
            'in' => 'required',
            'out' => 'required',
            'roles' => 'required|string|max:300',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }
        hotel::create([
            'h_name' => $request->name,
            'h_category' => $request->category,
            'h_body' => $request->body,
            'h_image' => $request->image,
            'h_stars' => $request->stars,
            'h_address' => $request->address,
            'h_capacity' => $request->capacity,
            'h_in' => $request->in,
            'h_out' => $request->out,
            'h_roles' => $request->roles,
        ]);
        return $this->successResponse([
            'message' =>  'hotel created',
        ], 201);
    }

    public function show()
    {
        $hotel = hotel::leftjoin('categories', 'hotels.h_category', '=', 'categories.c_id')->latest('hotels.created_at')
            ->get();
        return $this->successResponse([
            'message' => "درخواست موفق",
            'hotels' =>   $hotel
        ], 200);
    }

    public function show_by_id($id)
    {
        $hotel = hotel::leftjoin('categories', 'hotels.h_category', '=', 'categories.c_id')->where('id', $id)->first();
        return $this->successResponse([
            'message' => "درخواست موفق",
            'hotel' =>   $hotel
        ], 200);
    }
    public function edit(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:250',
            'category' => 'required|max:100',
            'body' => 'required|string',
            'image' => 'required|string',
            'stars' => 'required',
            'address' => 'required|string|max:300',
            'capacity' => 'required',
            'in' => 'required',
            'out' => 'required',
            'roles' => 'required|string|max:300',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }
        if ($request->image == null) {
            hotel::where('id', $id)->update([
                'h_name' => $request->name,
                'h_category' => $request->category,
                'h_body' => $request->body,
                'h_image' => $request->image,
                'h_stars' => $request->stars,
                'h_address' => $request->address,
                'h_capacity' => $request->capacity,
                'h_in' => $request->in,
                'h_out' => $request->out,
                'h_roles' => $request->roles,
            ]);
        } else {
            hotel::where('id', $id)->update([
                'h_name' => $request->name,
                'h_category' => $request->category,
                'h_body' => $request->body,
                'h_stars' => $request->stars,
                'h_address' => $request->address,
                'h_capacity' => $request->capacity,
                'h_in' => $request->in,
                'h_out' => $request->out,
                'h_roles' => $request->roles,
            ]);
        }
        return $this->successResponse([
            'message' =>  'hotel created',
        ], 201);
    }


    public function delete($id)
    {
        hotel::where('id', $id)->delete();
    }

    public function filter(Request $request)
    {
        $category = $request->input('category');
        $stars = $request->input('stars');
        $cap = $request->input('cap');
        $hotel =  hotel::where('h_category', 'LIKE', "%{$category}%")->where('h_stars', 'LIKE', "%{$stars}%")->where('h_capacity', 'LIKE', "%{$cap}%")->get();
        return $this->successResponse([
            'message' => "جستجو با موفقیت انجام شد",
            'hotel' =>  $hotel,
        ], 200);
    }
}
