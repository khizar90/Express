<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use stdClass;
use Exception;
use Stripe\Stripe;
class PaymentController extends Controller
{
    public function makePayment(Request $request)

    {
        $obj = new stdClass();
        $validator = Validator::make($request->all(), [
            'name_on_card' => 'required|string|max:255',
            'card_number' => 'required|numeric|digits_between:12,19',
            'card_cvc' => 'required|numeric|digits_between:3,4',
            'card_expiry_month' => 'required|numeric|between:1,12',
            'card_expiry_year' => 'required|numeric|digits:4',
            'amount' => 'required',
            'bus_id' => 'required|exists:buses,id',
            'user_id' => 'required|exists:users,id',
            'route_id' => 'required|exists:routes,id',
            'seat_no' => 'required',
            'name' => 'required',
            'country_code' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'date' => 'required|date_format:d-m-Y'
        ]);
        $errorMessage = implode(', ', $validator->errors()->all());


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'action' =>  $errorMessage,
            ]);
        } else {
            try {

                $stripe = new \Stripe\StripeClient('sk_test_4eC39HqLyjWDarjtT1zdp7dc');

                $res = $stripe->tokens->create([
                    'card' => [
                        'name' => $request->name_on_card,
                        'number' => $request->card_number,
                        'cvc' => $request->card_cvc,
                        'exp_month' => $request->card_expiry_month,
                        'exp_year' => $request->card_expiry_year,

                    ]
                ]);

                Stripe::setApiKey(env('STRIPE_SECRET'));

                $response = $stripe->charges->create([
                    'amount' => $request->amount,
                    'currency' => 'usd',
                    'source' => $res->id,
                    'description' => 'This is first transction '
                ]);

                if($response->status == 'succeeded'){
                    $phone = $request->country_code . $request->phone;        
                    $seat = new Seat();

                    $seat->bus_id = $request->bus_id;
                    $seat->route_id = $request->route_id;
                    $seat->user_id = $request->user_id;
                    $seat->seat_no = $request->seat_no;
                    $seat->name = $request->name;
                    $seat->phone = $phone;
                    $seat->gender = $request->gender;
                    $seat->card_name = $request->name_on_card;
                    $seat->card_number = $request->card_number;
                    $seat->gender = $request->gender;
                    $seat->date = $request->date;

                    $seat->save();


                    $noti = new Notification();
                    $noti->user_id = $request->user_id;
                    $noti->seat_id = $seat->id;
                    $noti->message = 'Your ticket has been successfully reserved and confirmed';
                    $noti->save();

                }

                return response()->json([
                    'status' => true,
                    'action' => 'Payment successful!',
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'satus' => false,
                    'error' => $e->getMessage()
                ], 500);
            }
        }
    }
}
