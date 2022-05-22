<?php

namespace App\Http\Controllers;

use App\Models\OTP;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Message;

class AuthController extends ApiController
{
    public function auth(Request $request)
    {
        $number = mt_rand(1000, 9999);
        $user_id = mt_rand(10000, 99999);
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }
        $user = User::where('email', $request->email)->first();
        if ($user == null) {
            $user = User::create([
                'id' => $user_id,
                'email' => $request->email,
                'role' => 1,
            ]);
            OTP::create(
                [
                    'o_code' => $number,
                    'o_user' => $user_id,
                ]
            );
            $details = [
                'otp' => $number
            ];
            Mail::to($user->email)->send(new \App\Mail\SampleMail($details));
            return $this->successResponse([
                'Next' =>  'OTP',
            ], 201);
        } else {
            $otpcodetime = otp::where('o_user', $user->id)->first();
            if ($otpcodetime !== null) {
                $checkDays = Carbon::now();
                $interval = $otpcodetime->created_at->diff($checkDays);
                if ($interval->format('%i') > 1) {
                    OTP::where('o_user', $user->id)->delete();
                    OTP::create(
                        [
                            'o_code' => $number,
                            'o_user' => $user->id,
                        ]
                    );
                    $details = [
                        'otp' => $number
                    ];
                    Mail::to($user->email)->send(new \App\Mail\SampleMail($details));
                    return $this->successResponse([
                        'Next' =>  'OTP',
                    ], 201);
                } else {
                    return $this->errorResponse([
                        'message' => 'برای ارسال درخواست 2 دقیقه صبر کنید'
                    ], 422);
                }
            } else {
                OTP::where('o_user', $user->id)->delete();
                OTP::create(
                    [
                        'o_code' => $number,
                        'o_user' => $user->id,
                    ]
                );
                $details = [
                    'otp' => $number
                ];
                Mail::to($user->email)->send(new \App\Mail\SampleMail($details));
                return $this->successResponse([
                    'Next' =>  'OTP',
                ], 201);
            }
        }
    }
}
