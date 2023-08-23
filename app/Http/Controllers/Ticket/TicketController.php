<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\BusSchedule;
use App\Models\Route;
use App\Models\Seat;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{

    public function seat($bus_id, $route_id)
    {
        $bus = Bus::find($bus_id);
        if ($bus) {

            $seat = Seat::select('seat_no', 'gender')->where('bus_id', $bus_id)->where('route_id', $route_id)->get();
            if ($seat->count() > 0) {
                return response()->json([
                    'status' => true,
                    'action' => "Booked seats",
                    'data' => ['bus' => $bus, 'seats' => $seat],
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'action' => "Not Seats book yet",
                ]);
            }
            
        }
        else{
            return response()->json([
                'status' => false,
                'action' => "No Bus Found",
            ]);
        }
    }


    public function myTickets($user_id)
    {
        $tickets = Seat::where('user_id', $user_id)->orderBy('created_at', 'desc')->paginate(12);
        if ($tickets->count() > 0) {
            foreach ($tickets as $ticket) {
                $bus = Bus::find($ticket->bus_id);
                $route = Route::find($ticket->route_id);
                $schedule = BusSchedule::select('departure_time', 'arrival_time', 'charge')->where('route_id', $ticket->route_id)->first();
                $ticket->route = $route;
                $ticket->bus = $bus;
                $ticket->schedule = $schedule;
                $departureTime = new DateTime($schedule->departure_time);
                $arrivalTime = new DateTime($schedule->arrival_time);
                $totalTime = $departureTime->diff($arrivalTime);
                $ticket->total_time = $totalTime->format('%h hours %i minutes');
            }
            return response()->json([
                'status' => true,
                'action' => "Your Ticket",
                'data' => $tickets
            ]);
        } else {
            return response()->json([
                'status' => true,
                'action' => "You didn't Booked any ticket yet",
            ]);
        }
    }
}
