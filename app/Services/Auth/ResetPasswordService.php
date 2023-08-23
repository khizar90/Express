<?php

namespace  App\Services\Auth;

use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Support\Facades\Hash;
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;
use stdClass;

class ResetPasswordService
{

    public function resetVerify($request)
    {
        $phonenumber = $request->country_code . $request->phone;
        $user = User::where('phone', $phonenumber)->first();
        $obj = new stdClass();

        if ($user) {
            return response()->json([
                'status' => true,
                'action' => "Otp send",
            ]);
        } else {
            return response()->json([
                'status' => false,
                'action' => "Account not found",
            ]);
        }
        // if ($user) {
        //     $token = '43b1cf1648551a40d327068d641b8195';
        //     $twilio_sid = 'AC5ac333610113e17d5f9fdcd9c81585aa';
        //     $twilio_verify_sid = 'VAe7e0edeea8798c9b00115e3f3c9030b8';

        //     $twilio = new Client($twilio_sid, $token);

        //     try {
        //         $twilio->verify->v2->services($twilio_verify_sid)->verifications->create($phonenumber, "sms");
        //     } catch (RestException $e) {

        //         return response()->json([
        //             'status' => false,
        //             'action' => 'Otp Send Failed Please Try Again',
        //         ]);
        //     }

        //     return response()->json([
        //         'status' => true,
        //         'action' => "Otp send",
        //     ]);
        // } else {
        //     return response()->json([
        //         'status' => false,
        //         'action' => "Account not found",
        //     ]);
        // }
    }

    public function resetOtpVerify($request)
    {

        $code = 123456;
        $obj = new stdClass();

        $phone_number = $request->country_code . $request->phone;
        $verification_code = $request->otp;

        if ($verification_code == $code) {
            return response()->json([
                'status' => true,
                'action' => 'Verification successful',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'action' => 'Please enter correct Otp',
            ]);
        }

        // $token = '43b1cf1648551a40d327068d641b8195';
        // $twilio_sid = 'AC5ac333610113e17d5f9fdcd9c81585aa';
        // $twilio_verify_sid = 'VAe7e0edeea8798c9b00115e3f3c9030b8';

        // $twilio = new Client($twilio_sid, $token);

        // try {
        //     $verification = $twilio->verify->v2->services($twilio_verify_sid)
        //         ->verificationChecks
        //         ->create([
        //             'to' => $phone_number,
        //             'code' => $verification_code
        //         ]);
        // } catch (RestException $e) {
        //     return response()->json([
        //         'status' => false,
        //         'action' => 'No Record Found',
        //     ]);
        // }

        // if ($verification->status == 'approved') {

        //     return response()->json([
        //         'status' => true,
        //         'action' => 'Verification successful',
        //     ]);
        // } else {
        //     return response()->json([
        //         'status' => false,
        //         'action' => 'Please Enter Correct Otp',
        //     ]);
        // }
    }

    public function newPassword($request)
    {

        $obj = new stdClass();
        $phone = $request->country_code . $request->phone;
        $user = User::where('phone', $phone)->first();

        if ($user) {
            
            if (Hash::check($request->new_password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'action' => 'Old password is same',
                ]);
            } else {
                $user->update([
                    'password' => Hash::make($request->new_password)
                ]);
                return response()->json([
                    'status' => true,
                    'action' => 'New password set',
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'action' => 'Account not found',
            ]);
        }
    }
}
