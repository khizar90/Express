<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use stdClass;

class logoutController extends Controller
{

    public function logout(Request $request, $user_id)
    {
        $obj = new stdClass();
        $user = User::find($user_id);
        $validator = Validator::make($request->all(), [
            'device_id' => 'required'
        ]);

        $errorMessage = implode(', ', $validator->errors()->all());

        if ($validator->fails()) {
            
            return response()->json([
                'status' => false,
                'action' =>  $errorMessage,
            ]);
        } else {
            if ($user) {
                $device = UserDevice::where('user_id', $user_id)->where('device_id', $request->device_id);
                $device->delete();
                return response()->json([
                    'status' => true,
                    'action' => 'User logout',
                 
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'action' => 'User not found',
                ]);
            }
        }
    }
}
