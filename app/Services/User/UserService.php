<?php

namespace  App\Services\User;

use App\Models\Bus;
use App\Models\BusSchedule;
use App\Models\City;
use App\Models\Route;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Hash;
use stdClass;

class UserService
{
    public function route()
    {
        $cities = City::select('name')->pluck('name');

        return response()->json([
            'status' => true,
            'action' => 'Cities',
            'data' => $cities,
        ]);
    }


    public function routeResult($request)
    {
        $obj = new stdClass();
        $route = Route::where('departure', $request->departure)->where('arival', $request->arrival)->first();
        if ($route) {
            $date = new DateTime($request->date);

            $dayName = $date->format('l');
            $schedules = BusSchedule::where('route_id', $route->id)->where('status', 1)->get();
            $matchingSchedules = [];
            if ($schedules->count() > 0) {
                foreach ($schedules as $schedule) {
                    $daysAvailable = explode(',', $schedule->days);
                    if (in_array(strtolower($dayName), array_map('strtolower', $daysAvailable))) {
                        $bus = Bus::find($schedule->bus_id);
                        $schedule->bus_detail = $bus;
                        $schedule->route_detail = $route;
                        $departureTime = new DateTime($schedule->departure_time);
                        $arrivalTime = new DateTime($schedule->arrival_time);
                        $totalTime = $departureTime->diff($arrivalTime);
                        $schedule->total_time = $totalTime->format('%h hours %i minutes');
                        $matchingSchedules[] = $schedule;
                    }
                }
                if (count($matchingSchedules) > 0) {
                    return response()->json([
                        'status' => true,
                        'action' => 'Buses',
                        'data' => $matchingSchedules,
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'action' => 'No buses available on this date',
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'action' => 'We could not find any bus at this date',
                ]);
            }




            // if ($schedules->count() > 0) {
            //     $filteredSchedules = $schedules->filter(function ($schedule) use ($dayName) {
            //         $daysAvailable = explode(',', $schedule->days);
            //         return in_array(strtolower($dayName), array_map('strtolower', $daysAvailable));
            //     });

            //     if ($filteredSchedules->count() > 0) {
            //         foreach ($filteredSchedules as $schedule) {
            //             $bus = Bus::find($schedule->bus_id);
            //             $schedule->bus_detail = $bus;
            //             $schedule->route_detail = $route;
            //             $departureTime = new DateTime($schedule->departure_time);
            //             $arrivalTime = new DateTime($schedule->arrival_time);
            //             $totalTime = $departureTime->diff($arrivalTime);
            //             $schedule->total_time = $totalTime->format('%h hours %i minutes');
            //         }


            //         return response()->json([
            //             'status' => true,
            //             'action' => 'Buses',
            //             'data' => $filteredSchedules,
            //         ]);
            //     } else {
            //         return response()->json([
            //             'status' => false,
            //             'action' => 'We could not find any bus at this date',
            //         ]);
            //     }
            // } else {
            //     return response()->json([
            //         'status' => false,
            //         'action' => 'We could not find any bus at this date',
            //     ]);
            // }
        } else {
            return response()->json([
                'status' => false,
                'action' => 'We could not find any bus on this Route',
            ]);
        }
    }

    public function changePassword($request, $user_id)
    {
        $obj = new stdClass();
        $user = User::find($user_id);
        if ($user) {

            if (Hash::check($request->old_password, $user->password)) {
                if (Hash::check($request->new_password, $user->password)) {

                    return response()->json([
                        'status' => false,
                        'action' => "New password is same as old password",
                    ]);
                } else {
                    $user->update([
                        'password' => Hash::make($request->new_password)
                    ]);
                    return response()->json([
                        'status' => true,
                        'action' => "Password  change",
                    ]);
                }
            }
            return response()->json([
                'status' => false,
                'action' => "Old password is wrong",
            ]);
        }
        return response()->json([
            'status' => false,
            'action' => "Account not found",
        ]);
    }
}
