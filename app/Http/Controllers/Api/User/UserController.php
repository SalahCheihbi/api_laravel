<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    use GeneralTrait;
    public function login(Request $request)
    {
        try {
            $rules = [
                "email" => 'required',
                "password" => "required"

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            //login

            $credentials = $request->only(['email', 'password']);
            $token = Auth::guard('user-api')->attempt($credentials);

            if (!$token) {
                return $this->returnError('E001', 'Wrong email or password');
            }

            $user = Auth::guard('user-api')->user();
            $user->api_token = $token;
            //token
            return $this->returnData('user', $user, msg: "login successfully");
        } catch (\Exception $ex) {
            return $this->returnError($ex->getMessage(), $ex->getCode());
        }
    }
    public function logout(Request $request)
    {

         $token = $request->header('auth-token');
        if ($token) {
            JWTAuth::setToken($token)->invalidate();

            return $this -> returnSuccessMessage(msg: "logout successfully");
        } else {
            $this->returnError('E001', 'some thing went wrong');
        }
    }
}
