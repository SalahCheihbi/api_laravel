<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\GeneralTrait;

class AuthController extends Controller
{
    use GeneralTrait;
    public function login(Request $request)
    {

        $rules = [
            "email" => 'required|exists:admins:email',
            "password" => "required"

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }


        //login


    }

}

