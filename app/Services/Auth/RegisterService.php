<?php

namespace  App\Services\Auth;

use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Support\Facades\Hash;
use stdClass;
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;


class RegisterService
{
    public function register($request)
    {
        $obj = new stdClass();
        $phone = $request->country_code . $request->phone;

        $user = User::where('phone', $phone)->first();
        if ($user) {
            return response()->json([
                'status' => false,
                'action' => "The email has already been taken",
            ]);
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->phone = $phone;
            $user->password = Hash::make($request->password);
            $user->save();


            $user = User::where('phone', $phone)->first();


            $userdevice = new UserDevice();
            $userdevice->user_id = $user->id;
            $userdevice->device_name = $request->device_name ?? 'No name';
            $userdevice->device_id = $request->device_id ?? 'No ID';
            $userdevice->timezone = $request->timezone ?? 'No Time';
            $userdevice->token = $request->token ?? 'No tocken';
            $userdevice->save();


            return response()->json([
                'status' => true,
                'action' => "Register successfully",
                'data' => $user,
            ]);
        }
    }
}
