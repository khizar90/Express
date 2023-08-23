<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\OtpVerifyRequest;
use App\Http\Requests\Auth\UserVerifyRequest;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\RouteResult;
use App\Http\Requests\User\RouteResultRequest;
use App\Models\Bus;
use App\Models\BusImage;
use App\Models\BusSchedule;
use App\Models\Faq;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Report;
use App\Models\Route;
use App\Models\Seat;
use App\Models\User;
use App\Services\User\UserService;
use App\Services\User\UserServices;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use stdClass;
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;

class UserController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function route()
    {
        return $this->userService->route();
    }

    public function routeResult(RouteResultRequest $request)
    {
        return $this->userService->routeResult($request);
    }

    public function changePassword(ChangePasswordRequest $request, $user_id)
    {
        return $this->userService->changePassword($request, $user_id);
    }

    public function editProfile(Request $request, $user_id)
    {
        $obj = new stdClass();
        $user = User::find($user_id);
        if ($user) {
            $phonenumber = $request->country_code . $request->phone;
            $phone = $request->country_code . $request->phone;
            if ($user->phone == $phone) {
                if ($request->has('name')) {
                    $user->name = $request->name;
                }
                if ($request->has('image')) {
                    $image = $request->file('image');
                    $filename = time() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('profile'), $filename);

                    if ($user->image) {
                        $previousImagePath = public_path('profile') . '/' . $user->image;
                        if (file_exists($previousImagePath)) {
                            unlink($previousImagePath);
                        }
                    }

                    $user->image = $filename;
                }
                $user->save();
                return response()->json([
                    'status' => true,
                    'action' => "Profile edit",
                ]);
            } else {
                $find = User::where('phone', $phone)->first();
                if ($find) {
                    if ($request->has('name')) {
                        $user->name = $request->name;
                    }
                    return response()->json([
                        'status' => false,
                        'action' => "Phone number already taken",
                    ]);
                    if ($request->has('image')) {
                        $image = $request->file('image');
                        $filename = time() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('profile'), $filename);

                        if ($user->image) {
                            $previousImagePath = public_path('profile') . '/' . $user->image;
                            if (file_exists($previousImagePath)) {
                                unlink($previousImagePath);
                            }
                        }

                        $user->image = $filename;
                    }
                    $user->save();
                } else {

                    return response()->json([
                        'status' => true,
                        'action' => "Please verify phone number first",
                    ]);
                    // $token = 'e867cc609161bbafb21ce14ba03bed1c';
                    // $twilio_sid = 'AC6f074c7c95bdbb49e61273ad44467212';
                    // $twilio_verify_sid = 'VA9857fd5c14553a5fbec3e1b39e1b7f0b';
                    // $twilio = new Client($twilio_sid, $token);
                    // try {
                    //     $twilio->verify->v2->services($twilio_verify_sid)->verifications->create($phonenumber, "sms");
                    // } catch (RestException $e) {

                    //     return response()->json([
                    //         'status' => false,
                    //         'action' => 'Otp Send Failed Please Try Again',
                    //         // $e->getMessage()
                    //     ]);
                    // }

                    // return response()->json([
                    //     'status' => true,
                    //     'action' => "User verify otp send",
                    // ]);
                }
            }
        } else {
            return response()->json([
                'status' => false,
                'action' => "No User found",
            ]);
        }
    }

    public function editVerify(OtpVerifyRequest $request, $user_id)
    {

        $code = 123456;
        $obj = new stdClass();
        $phone_number = $request->country_code . $request->phone;
        $verification_code = $request->otp;
        if ($verification_code == $code) {
            $user = User::find($user_id);
            if ($user) {
                $user->phone = $phone_number;
                $user->save();
            }
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

        // $token = 'e867cc609161bbafb21ce14ba03bed1c';
        // $twilio_sid = 'AC6f074c7c95bdbb49e61273ad44467212';
        // $twilio_verify_sid = 'VA9857fd5c14553a5fbec3e1b39e1b7f0b';

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

        //     $user = User::find($user_id);
        //     if ($user) {
        //         $user->phone = $phone_number;
        //     }

        //     return response()->json([
        //         'status' => true,
        //         'action' => 'Verification successful',
        //     ]);
        // } else {
        //     return response()->json([
        //         'status' => false,
        //         'action' => 'Wrong Otp',
        //     ]);
        // }
    }
    public function removeImage($id)
    {
        $user  = User::find($id);
        $obj = new stdClass();

        if ($user) {
            if ($user->image) {

                $previousImagePath = public_path('profile') . '/' . $user->image;
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
                $user->image = '';

                $user->save();
                return response()->json([
                    'status' => true,
                    'action' => 'Image Deleted',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'action' => 'User Image is empty',
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'action' => 'No user found',
            ]);
        }
    }
    public function faq()
    {
        $faq = Faq::all();
        if ($faq) {
            return response()->json([
                'status' => true,
                'action' => "FAQs",
                'data' => $faq,
            ]);
        }
    }

    public function getNotification($user_id)
    {
        $user = User::find($user_id);
        if ($user) {
            $notifications = Notification::select('id', 'seat_id', 'message', 'is_read','created_at')->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();


            foreach ($notifications as $notification) {
                $created_at_utc = Carbon::parse($notification->created_at);
                $created_at_pakistan = $created_at_utc->setTimezone('Asia/Karachi');
                $time = $created_at_pakistan->format('h:i A');
                $notification->time = $time;
            }
            if (count($notifications) > 0) {
                return response()->json([
                    'status' => true,
                    'action' => "Notifiactions",
                    'data' => $notifications,
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'action' => "No Notifiactions",
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'action' => "User Not Found",
            ]);
        }
    }

    public function notificationDetail($id)
    {
        $detail = Notification::find($id);
        if ($detail) {

            $detail = Seat::find($detail->seat_id);
            $route = Route::find($detail->route_id);
            $bus = Bus::find($detail->bus_id);
            $schedule = BusSchedule::select('departure_time', 'arrival_time', 'charge')->where('bus_id', $detail->bus_id)->where('route_id', $detail->route_id)->first();
            $departureTime = new DateTime($schedule->departure_time);
            $arrivalTime = new DateTime($schedule->arrival_time);
            $totalTime = $departureTime->diff($arrivalTime);
            $detail->route = $route;
            $detail->bus = $bus;
            $detail->schedule = $schedule;
            $detail->totalTime = $totalTime->format('%h hours %i minutes');



            return response()->json([
                'status' => true,
                'action' => "Notifiaction Detail",
                'data' => $detail,
            ]);
        }
        return response()->json([
            'status' => false,
            'action' => "No Notifiaction Found",
        ]);
    }

    public function readNotification($not_id)
    {
        $not = Notification::find($not_id);
        if ($not) {
            $not->is_read = 1;
            $not->save();
            return response()->json([
                'status' => true,
                'action' => "Notification read",
            ]);
        } else {
            return response()->json([
                'status' => false,
                'action' => "No Notification found",
            ]);
        }
    }

    public function home()
    {
        $images = BusImage::select('image')->get(); // Retrieve all image records

        // Transform the images into an array of image URLs
        $imageUrls = $images->pluck('image')->map(function ($image) {
            return asset('bus/' . $image); // Assuming images are stored in the "storage" directory
        });
        return response()->json([
            'status' => true,
            'action' => "Images",
            'data' => $imageUrls,
        ]);
    }

    public function deleteAccount(Request $request, $id)
    {
        $obj = new stdClass();

        $validator = Validator::make($request->all(), [
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'action' => "Password is Required",
            ]);
        }


        $user = User::find($id);
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $reportIds = Report::where('user_id', $user->id)->pluck('id');

                Message::where(function ($query) use ($user, $reportIds) {
                    $query->where('from_id', $user->id)->whereIn('to_id', $reportIds)
                        ->orWhereIn('from_id', $reportIds)->where('to_id', $user->id);
                })->delete();


                Seat::where('user_id', $user->id)->delete();
                Report::where('user_id', $user->id)->delete();
                $user->delete();
                return response()->json([
                    'status' => true,
                    'action' => "User Deleted Successfully",
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'action' => "You enter wrong password",
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'action' => "User not found",
            ]);
        }
    }
}
