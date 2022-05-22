<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');

///user
Route::post('login', \App\Http\Controllers\AuthController::class . '@auth');
Route::post('otpconfirm', \App\Http\Controllers\OTPController::class . '@confirm');
Route::post('otpconfirm', \App\Http\Controllers\OTPController::class . '@confirm');
Route::get('get-user-info', \App\Http\Controllers\UserController::class . '@get_user_info');
Route::get('get-user-logout', \App\Http\Controllers\UserController::class . '@get_user_logout')->middleware('auth:api');
Route::get('role-check', \App\Http\Controllers\user::class . '@rolecheck')->middleware('auth:api');

///hotel
Route::post('create-hotel', \App\Http\Controllers\HotelController::class . '@create')->middleware('auth:api')->middleware('admin');
Route::get('show-hotels', \App\Http\Controllers\HotelController::class . '@show');
Route::get('show-hotel-by-id/{id}', \App\Http\Controllers\HotelController::class . '@show_by_id');
Route::POST('edit-hotel/{id}', \App\Http\Controllers\HotelController::class . '@edit')->middleware('auth:api')->middleware('admin');
Route::get('delete-hotel/{id}', \App\Http\Controllers\HotelController::class . '@delete')->middleware('auth:api')->middleware('admin');
Route::post('filter-hotel', \App\Http\Controllers\HotelController::class . '@filter');


////USER
Route::get('show-users', \App\Http\Controllers\user::class . '@show')->middleware('auth:api')->middleware('admin');
Route::get('show-user-byid/{users}', \App\Http\Controllers\user::class . '@showbyid')->middleware('auth:api')->middleware('admin');
Route::post('edit-user/{users}', \App\Http\Controllers\user::class . '@edit')->middleware('auth:api')->middleware('admin');

////category
Route::get('show-categories', \App\Http\Controllers\CategoryController::class . '@show');
Route::post('create-cat', \App\Http\Controllers\CategoryController::class . '@create')->middleware('auth:api')->middleware('admin');
Route::post('edit-cat/{id}', \App\Http\Controllers\CategoryController::class . '@edit')->middleware('auth:api');
Route::get('show-cat-by-id/{id}', \App\Http\Controllers\CategoryController::class . '@show_by_id')->middleware('auth:api')->middleware('admin');
Route::get('delete-cat/{id}', \App\Http\Controllers\CategoryController::class . '@delete')->middleware('auth:api')->middleware('admin')->middleware('admin');

////ANALYTICS
Route::get('ANALYTICS', \App\Http\Controllers\HomeController::class . '@ANALYTICS');

//image-upload
Route::post('image-upload', \App\Http\Controllers\upload::class . '@image');
