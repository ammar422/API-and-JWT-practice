<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiGenralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use function Laravel\Prompts\password;

class AuthController extends Controller
{
    use ApiGenralTrait;

    public function login(Request $request)
    {
        try {

            // validation
            $rules = [
                'email' => 'required',
                'password' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $credentials = $request->only('email', 'password');
            $token = Auth::guard('admin')->attempt($credentials);
            if (!$token) {
                return $this->returnError(404, 'Credentials are not correct');
            }
            $admin = Auth::guard('admin')->user();
            $admin->ApiToken = $token;
            return $this->returnData('admin',  $admin, 'generated successfuly');
        } catch (\Exception $e) {
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }


    public function logout(Request $request)
    {
        try {
            //code...
            $token = $request->header('auth-token');
            if ($token) {
                JWTAuth::setToken($token)->invalidate();
                return $this->returnSucces(205, 'token destroied and You have successfully logged out');
            } else
                return $this->returnError(402, 'token is missed');
        } catch (TokenInvalidException $e) {
            return $this->returnError(402,  'someting went wrong '.$e->getMessage());
        }
    }
}
