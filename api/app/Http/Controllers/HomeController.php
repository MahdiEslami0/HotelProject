<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\hotel;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\FlareClient\Api;

class HomeController extends ApiController
{
    public function ANALYTICS()
    {
        $user = User::count();
        $category = category::count();
        $hotel = hotel::count();
        return $this->successResponse([
            'infos' => [
                'User' =>  $user,
                'category' =>  $category,
                'hotel' =>  $hotel
            ]
        ], 201);
    }
}
