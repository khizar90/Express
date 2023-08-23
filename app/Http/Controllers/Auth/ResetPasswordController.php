<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\NewPasswordRequest;
use App\Http\Requests\Auth\OtpVerifyRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\UserVerifyRequest;
use App\Services\Auth\ResetPasswordService;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    protected $resetPasswordService;

    public function __construct(ResetPasswordService $resetPasswordService)
    {
        $this->resetPasswordService = $resetPasswordService;
    }

    public function resetVerify(UserVerifyRequest $request){
       
        return $this->resetPasswordService->resetVerify($request);
    }

    public function resetOtpVerify(OtpVerifyRequest $request){
       
        return $this->resetPasswordService->resetOtpVerify($request);
    }

    public function newPassword(NewPasswordRequest $request){
        return $this->resetPasswordService->newPassword($request);
    }
}
