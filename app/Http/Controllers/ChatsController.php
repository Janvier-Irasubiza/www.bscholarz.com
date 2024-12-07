<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Staff;
use App\Models\Message;
use App\Models\MessageReply;
use App\Mail\Support;
use Mail;

class ChatsController extends Controller
{
    function index()
    {

        $messages = Message::where('sender', auth('staff')->user()->id)
            ->orWhere('receiver', auth('staff')->user()->id)
            ->orderBy("created_at", "desc")
            ->paginate(10);

        return view('chats.chat', compact('messages'));
    }

    public function requestSupportForm()
    {
        $staff = Staff::all();
        return view('chats.request', compact('staff'));
    }

    public function requestSupport(Request $request)
    {
        $validatedData = $request->validate([
            'issue' => 'required|string',
            'issue_desc' => 'required|string',
            'receiver' => 'required|integer'
        ]);

        $message = new Message();
        $message->issue = $validatedData['issue'];
        $message->sender = auth('staff')->user()->id;
        $message->receiver = $validatedData['receiver'];
        $message->save();

        $messageReply = new MessageReply();
        $messageReply->message_id = $message->id;
        $messageReply->reply = $validatedData['issue_desc'];
        $messageReply->user_id = auth('staff')->user()->id;
        $messageReply->save();

        $user = Staff::find($validatedData['receiver']);

        // Send Email
        Mail::to($user->email)->send(new Support($validatedData['issue'], $validatedData['issue_desc']));

        return redirect()->route('chats.index')->with('success', 'Your Support Request Was Sent');
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

        return view('chats.chat-conv', compact('message'));
    }

    public function users($commentId)
    {
        // Fetch all users (staff)
        $users = Staff::all();

        // Add 'recommended' attribute to each user based on the specific comment ID
        $usersWithRecommendation = $users->map(function ($user) use ($commentId) {
            // Check if this user is recommended for the specified comment
            $isRecommended = Comment::where('id', $commentId)
                ->where('recommended_to', $user->id)
                ->exists();

            // Add 'recommended' attribute to indicate if the user is recommended for this comment
            $user->recommended = $isRecommended;

            return $user;
        });

        // Return users
        return response()->json($usersWithRecommendation);
    }

    public function getUsers()
    {
        // Fetch all users (staff)
        $users = Staff::whereNot('id', auth()->guard('staff')->user()->id)->get();

        // Return users
        return response()->json($users);
    }

    public function getIssues()
    {
        // Fetch all messages
        $messages = Message::all();

        // get sender and receiver
        $messages = $messages->map(function ($message) {
            $message->sender = Staff::find($message->sender);
            return $message;
        });
        $messages = $messages->map(function ($message) {
            $message->receiver = Staff::find($message->receiver);
            return $message;
        });

        // Get last reply
        $messages = $messages->map(function ($message) {
            $message->lastReply = MessageReply::where('message_id', $message->id)->orderBy('created_at', 'desc')->first();
            return $message;
        });

        return response()->json($messages);
    }

    public function getTags(Request $request)
    {
        // Fetch all tags
        $tags = Message::findOrFail($request->issue)->select('app', 'request', 'account', 'user', 'advert', 'subscriber_id', 'sub_plan_id', 'sub_service_id')->first();
        return response()->json($tags);
    }

    public function getIssueConv(Request $request)
    {

        $conv = MessageReply::where('message_id', $request->issue)
            ->select(['id', 'reply', 'created_at', 'user_id'])
            ->get();

        // Get user
        $conv = $conv->map(function ($message) {
            $message->user = Staff::find($message->user_id);
            return $message;
        });

        $response = [
            'content' => $conv,
            'user' => auth()->guard('staff')->user()->id,
        ];

        return response()->json($response);
    }

    public function reply(Request $request)
    {
        $validatedData = $request->validate([
            'chat' => 'integer|required|exists:messages,id', // Ensure 'chat' exists in the messages table
            'message' => 'required_without:attachement', // Prevent empty messages
            'attachement' => 'nullable|file|mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/jpeg,image/png,image/gif|max:5120',
        ]);

        // Fetch the authenticated user
        $user = auth()->guard('staff')->user();

        if (!$user) {
            return back()->withErrors(['error' => 'Unauthorized user.']); // Handle unauthenticated users
        }

        // Find the message and create the reply
        $message = Message::findOrFail($validatedData['chat']);
        $reply = new MessageReply();

        if ($request->hasFile('attachement')) {
            $file = $request->file('attachement');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('reports'), $fileName);
            $reply->attachement = $fileName;
            $reply->status = 'unread';
        }

        $reply->user_id = $user->id; // Assign the user ID
        $reply->message_id = $message->id; // Assign the message ID
        $reply->reply = $validatedData['message']; // Assign the reply text
        $reply->save();

        $user = Staff::find($message->receiver);

        // Send Email
        Mail::to($user->email)->send(new Support($message->issue, $validatedData['message']));

        return back()->with('success', 'Reply added successfully!'); // Redirect back with a success message
    }


    public function issueReply(Request $request)
    {

        $request->merge(array_map(
            fn($value) => $value === '' ? null : $value,
            $request->all()
        ));

        $validatedData = $request->validate([
            'chat' => 'integer|required',
            'message' => 'string|required',
            'app' => 'string|nullable',
            'request' => 'string|nullable',
            'account' => 'string|nullable',
            'user' => 'string|nullable',
            'advert' => 'string|nullable',
            'subscriber_id' => 'string|nullable',
            'sub_plan_id' => 'string|nullable',
        ]);

        $reply = new MessageReply;
        $reply->message_id = $request->chat;
        $reply->reply = $request->message;
        $reply->user_id = auth()->guard('staff')->user()->id;
        $reply->save();

        $issue = Message::findOrFail($validatedData['chat']);
        if ($issue) {
            $nonNullData = array_filter($validatedData, function ($value) {
                return !is_null($value);
            });

            unset($nonNullData['chat'], $nonNullData['message']);
            $issue->update($nonNullData);
        }

        return response()->json(['success' => 'Reply sent'], 201);
    }

    public function getUserInfo(Request $request)
    {
        $user = Staff::where('uuid', $request->user)->first();
        $response = [
            'receiver_id' => $user->id,
            'receiver_names' => $user->names,
            'receiver_role' => $user->role,
            'sender_id' => auth()->guard('staff')->user()->id,
            'sender_names' => auth()->guard('staff')->user()->names,
        ];

        return response()->json($response);
    }

}
