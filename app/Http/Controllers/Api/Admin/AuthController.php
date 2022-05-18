<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use GeneralTrait;
    public function login(Request $request)
    {
        try {
            $rules = [
                "email" => 'required|exists:admins,email',
                "password" => "required"

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            //login

            $credentials = $request->only(['email', 'password']);
            $token = Auth::guard('admin-api')->attempt($credentials);

            if (!$token) {
                return $this->returnError('E001', 'Wrong email or password');
            }


            //token
            return $this->returnData('admin', $token);
        } catch (\Exception $ex) {
            return $this->returnError($ex->getMessage(), $ex->getCode());
        }
    }
}
