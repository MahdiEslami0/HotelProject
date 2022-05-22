<?php

namespace App\Http\Controllers;

use App\Models\OTP;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OTPController extends ApiController
{
    public function confirm(Request $request)
    {
        $user = user::where('email', $request->email)->first();
        $otp = OTP::where('o_user', $user->id)->where('o_code', $request->otpcode)->first();
        if ($user == null) {
            return $this->errorResponse([
                'message' =>  'User notfound',
            ], 422);
        } else {
            if ($otp ==  null) {
                return $this->errorResponse([
                    'message' =>  'Otp wrong',
                ], 401);
            } else {
                DB::table('oauth_access_tokens')->where('user_id', $user->id)->delete();
                OTP::where('o_user', $user->id)->delete();
                $token = $user->createToken('token')->accessToken;
                return $this->successResponse(
                    [
                        'message' => 'login success',
                        'token' =>   $token,
                    ],
                    201
                );
            }
        }
    }
}
