<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\OtpVerifyRequest;
use App\Http\Requests\Auth\UserVerifyRequest;
use App\Services\Auth\UserVerifyService;
use Illuminate\Http\Request;

class UserVerifyController extends Controller
{
    protected $verifyService;

    public function __construct(UserVerifyService $verifyService)
    {
        $this->verifyService = $verifyService;
    }

    public function userVerify(UserVerifyRequest $request){

        return $this->verifyService->userVerify($request);
       
    }

    public function otpVerify(OtpVerifyRequest $request){

        return $this->verifyService->otpVerify($request);
        
    }
   
}
