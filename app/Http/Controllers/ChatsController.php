<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatsController extends Controller
{
    function  index() {
        return view('chats.chat');
    }

    public function users($commentId) {
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
    
    public function getUsers() {
        // Fetch all users (staff)
        $users = Staff::whereNot('id', auth()->guard('staff')->user()->id)->get();

        // Return users
        return response()->json($users);
    }

    public function getIssues() {
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

    public function getTags(Request $request) {
        // Fetch all tags
        $tags = Message::findOrFail($request->issue)->select('app', 'request', 'account', 'user', 'advert', 'subscriber_id', 'sub_plan_id', 'sub_service_id')->first();
        return response()->json($tags);
    }

    public function getIssueConv(Request $request) {
    
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

    public function issueReply(Request $request) {
        
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

    public function getUserInfo(Request $request) {
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
