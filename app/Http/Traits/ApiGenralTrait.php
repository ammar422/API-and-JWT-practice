<?php

namespace App\Http\Traits;



trait ApiGenralTrait
{

    public function returnError($erorrNum, $msg)
    {
        return response()->json([
            'status' => false,
            'erorrNum' => $erorrNum,
            'msg' => $msg,

        ]);
    }

    public function returnSucces($erorrNum, $msg)
    {
        return response()->json([
            'status' => true,
            'erorrNum' => $erorrNum,
            'msg' => $msg,

        ]);
    }

    public function returnData($key, $value, $msg = null)
    {
        return response()->json([
            'status' => true,
            'errorNum' => 5000,
            'msg' => $msg,
            $key => $value
        ]);
    }

    public function returnValidationError($code, $validator)
    {
        return $this->returnError($code, $validator->errors()->first());
    }

    public function returnCodeAccordingToInput($validator)
    {
        $inputs = array_keys($validator->errors()->toArray());
        $code = $this->getErrorCode($inputs[0]);
        return $code;
    }

    public function getErrorCode($input)
    {
        if ($input == "email")
            return 'E.email.301';
        elseif ($input == "password")
            return 'E.Password.301';
        else
            return "null";
    }
}
