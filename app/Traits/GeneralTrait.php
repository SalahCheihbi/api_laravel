<?php

namespace App\Traits;

trait GeneralTrait
{
    public function getCurrentLang()
    {
        return app()->getLocale();
    }
    public function returnError($msg, $errNum)
    {
        return response()->json([
            'status' => false,
            'message' => $msg,
            'errNum' => $errNum

        ]);
    }
    public function returnSuccessMessage($msg = "", $errNum = "S000")
    {
        return [
            'status' => true,
            'message' => $msg,
            'errNum' => $errNum
        ];
    }
    public function returnData($key, $value, $msg = "")
    {
        return response()->json([
            'status' => true,
            'errNum' => 'S000',
            'msg' => $msg, $key => $value
        ]);
    }
}
