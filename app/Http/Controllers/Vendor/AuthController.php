<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiGenralTrait;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use ApiGenralTrait;
    //
    public function getProfile()
    {
        return $this->returnError(505, 'only vendors can reach me');
    }

    public function getAllVendors()
    {
        $Vendors = Vendor::select()->get();
        return $this->returnData('vendors', $Vendors, 'returned successfuly');
    }


    public function getVendor(Request $request)
    {
        try {
            $rules = [
                'id' => 'required'
            ];
            $validation = Validator::make($request->all(), $rules);
            if ($validation->fails()) {
                $code = $this->returnCodeAccordingToInput($validation);
                return $this->returnValidationError($code, $validation);
            }
            $vendor = Vendor::select()->find($request->id);
            if (!$vendor)
                return $this->returnError(505, 'notfound');
            return $this->returnData('vendor', $vendor, 'returned successfuly');
        } catch (\Exception $ex) {
            return $this->returnError(811, $ex->getMessage());
        }
    }



    public function login(Request $request)
    {
        try {

            // validation
            $rules = [
                'email' => 'required',
                'password' => 'required'
            ];
            $validation = Validator::make($request->all(), $rules);
            if ($validation->fails()) {
                $code = $this->returnCodeAccordingToInput($validation);
                return $this->returnValidationError($code, $validation);
            }

            $credentials = $request->only(['email', 'password']);
            $token = Auth::guard('vendor')->attempt($credentials);

            if (!$token) {
                return $this->returnError(404, 'Credentials are not correct');
            }

            $vendor = Auth::guard('vendor')->user();
            $vendor->vendorToken = $token;


            return $this->returnData('vendor', $vendor, 'logged in successfuly');
        } catch (\Exception $ex) {

            return $this->returnError(555, $ex->getMessage());
        }
    }


    public function logout(request $request)
    {
        try {
            $token = $request->header('auth-token');
            if($token){
                JWTAuth::setToken($token)->invalidate();
                return $this->returnSucces(1001,'token destroied and You have successfully logged out');
            }else
            return $this->returnError(1002,'some thing went rong !!!');
        } catch (\Exception $ex) {
            return $this->returnError(555, $ex->getMessage());
        }
    }
}
