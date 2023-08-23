<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Report;
use App\Models\ReportCategory;
use App\Models\User;
use Illuminate\Http\Request;
use stdClass;
use Twilio\TwiML\Voice\Conversation;
use Pusher\Pusher;

class ReportController extends Controller
{
    public function report($status)
    {

        if ($status == 'active') {
            $reports = Report::where('status', 1)->get();

            foreach ($reports as $report) {
                $user = User::find($report->user_id);
                $category = ReportCategory::find($report->category_id);
                $report->user = $user;
                $report->category = $category;
            }
        } else {
            $reports = Report::where('status', 0)->get();

            foreach ($reports as $report) {
                $user = User::find($report->user_id);
                $category = ReportCategory::find($report->category_id);

                $report->user = $user;
                $report->category = $category;
            }
        }
        return view('user.report', compact('reports' ,'status'));
    }




    public function messages($channel)
    {
        $ids = explode('-', $channel);
        $from = $ids[0]; // First ID
        $to = $ids[1];

        $conversation = Message::where([
            ['to_id', $from],
            ['from_id', $to],
        ])
            ->orWhere([
                ['to_id', $to],
                ['from_id', $from],
            ])
            ->orderBy('created_at', 'asc')
            ->get();

        $user = Message::select('from_id')->where('to_id', $to)->first();

        $findUser = User::find($user)->first();
        $report = Report::find($to);
        $cat = ReportCategory::find($report->category_id);
        $channelName = $channel;

        foreach ($conversation as $time) {

            $createdAt = $time['created_at'];
            $userTimezone = auth()->user()->timezone;
            $convertedTime = $createdAt->setTimezone($userTimezone);
        }



        return view('user.chat', compact('conversation', 'to', 'report', 'from', 'findUser', 'cat', 'channelName' ,'convertedTime'));
    }

    public function closeReport($report_id)
    {
        $obj = new stdClass();
        $report = Report::find($report_id);
        if ($report) {
            $report->status = 0;
            $report->save();
            return redirect()->route('dashboard-report', 'active');
        }
    }


    public function sendMessage(Request $request)
    {
        $message = new Message();
        $image = '';
        $textMessage = '';
        if ($request->has('attachment') && $request->message != null) {
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

        $message->from_id = $request->ticket_id;
        $message->to_id = $request->user_id;
        $message->channel = $request->user_id . '-' . $request->ticket_id;
        $message->sendBy = 'admin';

        $message->save();


        $pusher = new Pusher('97a86cd58ea79e2dcf60', 'b5483068e833f5277aaa', 1646483, [
            'cluster' => 'us3',
            'useTLS' => true,
        ]);


        $pusher->trigger($message->channel, 'new-message', [
            // 'message' => $userMessage,
            // 'sendBy' => $userMessage->sendBy,
            // 'user'   => $user,
            // 'message' => $userMessage->message,
            // 'sender' => $userMessage->sendBy,
            'attachment' => $message->attachment ? asset('messages/' . $message->attachment) : null,
            'message' => $message,
            'sender' => 'admin',
        ]);


        return redirect()->back();
    }
}
