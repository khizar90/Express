<?php

namespace  App\Services\Auth;

use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Support\Facades\Hash;
use stdClass;


class LoginService
{
    public function login($request)
    {


        $obj = new stdClass();

        $phone = $request->country_code . $request->phone;


        $user = User::where('phone', $phone)->first();

        if ($user) {

            if (Hash::check($request->password, $user->password)) {

                $userdevice = new UserDevice();
                $userdevice->user_id = $user->id;
                $userdevice->device_name = $request->device_name ?? 'No name';
                $userdevice->device_id = $request->device_id ?? 'No ID';
                $userdevice->timezone = $request->timezone ?? 'No Time';
                $userdevice->token = $request->token ?? 'No tocken';
                $userdevice->save();

                $user->save();
                if($user->image){
                    $user->image = asset('profile/' . $user->image);
                }

                return response()->json([
                    'status' => true,
                    'action' => "Login successfully",
                    'data' => $user,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'action' => "Please Enter Correct Password",
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'action' => "User Not Found",
            ]);
        }





        return response()->json([
            'status' => false,
            'action' => "Login failed",
            'data' => $obj,
            'error' => ['Invalid platform']
        ]);
    }
}