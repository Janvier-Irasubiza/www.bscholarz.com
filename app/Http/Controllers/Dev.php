<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Staff;
use App\Models\MessageReply;
use App\Mail\Support;
use Mail;

class Dev extends Controller
{
    public function index()
    {
        $messages = Message::where('sender', auth('staff')->user()->id)
            ->orWhere('receiver', auth('staff')->user()->id)
            ->orderBy("created_at", "desc")
            ->paginate(10);

        return view('dev.dashboard', compact('messages'));
    }

    public function chat(Request $request)
    {
        $message = Message::where('uuid', $request->chat)
            ->with([
                'replies' => function ($query) {
                    $query->with('user');
                }
            ])
            ->first();

        if ($message && $message->replies) {
            foreach ($message->replies as $reply) {
                $reply->status = 'read';
                $reply->save();
            }
        }

        return view('dev.chat', compact('message'));
    }

    public function reply(Request $request)
    {
        $validatedData = $request->validate([
            'chat' => 'integer|required|exists:messages,id', // Ensure 'chat' exists in the messages table
            'message' => 'string|required|min:1', // Prevent empty messages
        ]);

        // Fetch the authenticated user
        $user = auth()->guard('staff')->user();

        if (!$user) {
            return back()->withErrors(['error' => 'Unauthorized user.']); // Handle unauthenticated users
        }

        // Find the message and create the reply
        $message = Message::findOrFail($validatedData['chat']);
        $reply = new MessageReply();

        $reply->user_id = $user->id; // Assign the user ID
        $reply->message_id = $message->id; // Assign the message ID
        $reply->reply = $validatedData['message']; // Assign the reply text
        $reply->save();

        $user = Staff::find($message->receiver);

        // Send Email
        Mail::to($user->email)->send(new Support($message->issue, $validatedData['message']));

        return back()->with('success', 'Reply added successfully!'); // Redirect back with a success message
    }
}
