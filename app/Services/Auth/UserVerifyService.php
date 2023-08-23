<?php

namespace  App\Services\Auth;

use App\Models\User;
use stdClass;
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;


class UserVerifyService
{
    public function userVerify($request)
    {

        $obj = new stdClass();
        $phonenumber = $request->country_code . $request->phone;
        $user = User::where('phone', $phonenumber)->first();
        if ($user) {
            return response()->json([
                'status' => false,
                'action' => "Account already exists on this number",
            ]);
        } else {
            return response()->json([
                'status' => true,
                'action' => "User verify Otp send",
            ]);
        }


        // if ($user) {
        //     return response()->json([
        //         'status' => false,
        //         'action' => "Phone Number Already Exists",
        //     ]);
        // } else {

        //     $token = '43b1cf1648551a40d327068d641b8195';
        //     $twilio_sid = 'AC5ac333610113e17d5f9fdcd9c81585aa';
        //     $twilio_verify_sid = 'VAe7e0edeea8798c9b00115e3f3c9030b8';
        //     $twilio = new Client($twilio_sid, $token);
        //     try {
        //         $twilio->verify->v2->services($twilio_verify_sid)->verifications->create($phonenumber, "sms");
        //     } catch (RestException $e) {
                
                

        //         return response()->json([
        //             'status' => false,
        //             'action' =>'Otp Send Failed Please Try Again',
        //         ]);
        //     }

        //     return response()->json([
        //         'status' => true,
        //         'action' => "User verify and  otp send",
        //     ]);
        // }
    }

    public function otpVerify($request)
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
                'action' => 'Please enter correct otp',
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
        //         'action' => 'No Recode Found',
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
        //         'action' => 'Invalid Otp',
        //     ]);
        // }
    }
}
