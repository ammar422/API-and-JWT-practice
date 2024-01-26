<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiGenralTrait;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

            // login


            $credentials = $request->only('email', 'password');
            $token = Auth::guard('admin')->attempt($credentials);
            $admin = Auth::guard('admin')->user();
            $admin ->ApiToken = $token ;
            if (!$token) {
                return $this->returnError(404, 'Credentials are not correct');
            }
            return $this->returnData('admin',  $admin, 'generated successfuly');
        } catch (\Exception $e) {
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }
}
