<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Mail\ReportCreated;
use App\Models\Bus;
use App\Models\BusSchedule;
use App\Models\Message;
use App\Models\Report;
use App\Models\ReportCategory;
use App\Models\Route;
use App\Models\Seat;
use App\Models\User;
use DateTime;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use stdClass;
use Pusher\Pusher;


class ReportController extends Controller
{
    public function reportCategory()
    {
        $category = ReportCategory::pluck('name');
        if ($category->count() > 0) {
            return response()->json([
                'status' => true,
                'action' => "Categories",
                'data' => $category,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'action' => "No Category Found",
            ]);
        }
    }

    public function addCategory(Request $request)
    {
        $obj = new stdClass();
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:report_categories,id',
            'message' => 'required'
        ]);
        $errorMessage = implode(', ', $validator->errors()->all());

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'action' =>  $errorMessage,
            ]);
        } else {
            $report = new Report();
            $report->category_id = $request->category_id;
            $report->user_id = $request->user_id;
            $report->message = $request->message;
            $report->save();

            $message = new Message();
            $message->from_id = $request->user_id;
            $message->to_id = $report->id;
            $message->type = 'text';
            $message->message = $request->message;
            $message->attachment = '';
            $message->sendBy = 'user';
            $message->channel = $request->user_id . '-' . $report->id;
            $message->save();


            $defaultMessage = new Message();
            $defaultMessage->from_id = $report->id;
            $defaultMessage->to_id = $request->user_id;
            $defaultMessage->type = 'text';
            $defaultMessage->message = 'Hi,👋Thanks for your message. We ll get back to you within 24 hours.';
            $defaultMessage->attachment = '';
            $defaultMessage->sendBy = 'admin';
            $defaultMessage->channel = $request->user_id . '-' . $report->id;
            $defaultMessage->save();


            $user = User::find($request->user_id);
            $cat = ReportCategory::find($request->category_id);
            $karachiTime = Carbon::parse($report->created_at)->timezone('Asia/Karachi');
            $mail_details = [
                'subject' => 'Express',
                'body' => $request->message,
                'user' => $user->name,
                'category' => $cat->name,
                'time' => $karachiTime->format('Y-m-d H:i:s')
            ];

            // Mail::to('khzrkhan0000@gmail.com')->send(new \App\Mail\ReportCreated());

            Mail::to('zrzunair10@gmail.com')->send(new ReportCreated($mail_details));

            return response()->json([
                'status' => true,
                'action' => "Report Added",
            ]);
        }
    }

    public function userReport($user_id, $status)
    {
        $reports = Report::where('user_id', $user_id)->where('status', $status)->orderBy('created_at', 'desc')->paginate(12);
        if ($reports->count() > 0) {
            foreach ($reports as $report) {
                $category = ReportCategory::select('name')->where('id', $report->category_id)->first();
                $report->category = $category;

                $createdAtDateTime = new DateTime($report->created_at);

                $formattedDate = $createdAtDateTime->format('d-n-Y H:i:s');

                $report->dateAndTime = $formattedDate;
            }
            return response()->json([
                'status' => true,
                'action' => "User Reports",
                'data' => $reports,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'action' => "No reports found",
            ]);
        }
    }

    public function closeTicket($report_id)
    {
        $obj = new stdClass();
        $report = Report::find($report_id);
        if ($report) {
            $report->status = 0;
            $report->save();
            return response()->json([
                'status' => true,
                'action' => "Report Close",
            ]);
        } else {
            return response()->json([
                'status' => false,
                'action' => "No reports found",
            ]);
        }
    }

    public function sendMessage(Request $request)
    {
        $obj = new stdClass();
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'report_id' => 'required|exists:reports,id',
            'type' => 'required',
            'message' => 'required_without:attachment'

        ]);

        $errorMessage = implode(', ', $validator->errors()->all());
        if ($validator->fails()) {
            return response()->json([
                'status' => true,
                'action' => $errorMessage,
            ]);
        }
        $image = '';
        $textMessage = '';


        $message = new Message();
        $message->from_id = $request->user_id;
        $message->to_id = $request->report_id;
        // $message->type = $request->type;
        $message->sendBy = 'user';

        $message->message = $request->message;
        $message->channel = $request->user_id . '-' . $request->report_id;


        if ($request->has('attachment') && $request->has('message')) {
            $image = $request->file('attachment');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('messages'), $filename);
            $message->attachment = $filename;
            $message->message = $request->message;
            $message->type = 'attachment';
        } elseif ($request->has('attachment')) {
            $image = $request->file('attachment');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('messages'), $filename);
            $message->attachment = $filename;
            $message->message = $textMessage;
            $message->type = 'attachment';
        } elseif ($request->has('message')) {
            $message->attachment = $image;
            $message->message = $request->message;
            $message->type = 'text';
        }


        $message->save();
        $user = User::find($request->user_id);



        $pusher = new Pusher('97a86cd58ea79e2dcf60', 'b5483068e833f5277aaa', 1646483, [
            'cluster' => 'us3',
            'useTLS' => true,
        ]);

        $pusher->trigger($message->channel, 'new-message', [
            'message' => $message,
            'sender' => $message->sendBy,
            'user'   => $user,
            // 'message' => $userMessage->message,
            // 'sender' => $userMessage->sendBy,
            'attachment' => $message->attachment ? asset('messages/' . $message->attachment) : null,
            'profile' => $user->image ? asset('profile/' . $user->image) : null,
        ]);


        return response()->json([
            'status' => true,
            'action' => "Message send",
        ]);
    }

    public function conversation($channel)
    {
        $messages = Message::where('channel', $channel)->get();

        $channelValues = explode('-', $channel);
        $user_id = $channelValues[0];
        $ticket_id = $channelValues[1];


        foreach ($messages as $message) {
            $user =  User::select('name')->where('id', $user_id)->first();
            $message->user = $user;
            $category = ReportCategory::select('name')->where('id', $ticket_id)->first();
            $message->category = $category;
        }

        return response()->json([
            'status' => true,
            'action' => "Conversation",
            'data' => $messages,
        ]);
    }
}
