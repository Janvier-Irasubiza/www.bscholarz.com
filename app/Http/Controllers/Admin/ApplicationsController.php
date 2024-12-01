<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\Discipline;
use File;
use Illuminate\Http\Request;
use DB;
use Mail;
use App\Mail\Post;
use Session;
use App\Http\Controllers\MailController;
use Auth;

class ApplicationsController extends Controller {

    public function applications(Request $request) {
      $query = Discipline::where('category', '<>', 'Custom')
          ->orderBy('publish_date', 'ASC');

      if ($request->has('app') && $request->app != '') {
          $search = $request->app;
          $query->where(function($q) use ($search) {
              $q->where('discipline_name', 'LIKE', "%{$search}%");
          });
      }

      $applications = $query->paginate(10);

      return view('admin.applications', compact('applications'));
    }


    public function application_info (Request $request) {
        $app_info = DB::table('disciplines') -> where('identifier', $request -> identifier) -> first();
        if ($app_info) {
            $comments = Comment::where('discipline_id', $app_info->id)->count();
        } else {
          $comments = 0;
        }
        return view ('admin.application-info', compact('app_info', 'comments'));
    }

    public function comments_view(Request $request) {
        $app_info = Discipline::where('identifier', $request -> app_id) -> first();
        return view('admin.comments', compact('app_info'));
    }

    public function comments() {
        $comments = Comment::with(['user', 'replies.user'])
            ->get()
            ->map(function($comment) {
                return [
                    'id' => $comment->id,
                    'discipline_id' => $comment->discipline_id,
                    'applicant_id' => $comment->applicant_id,
                    'comment' => $comment->comment,
                    'status' => $comment->status,
                    'created_at' => $comment->created_at,
                    'updated_at' => $comment->updated_at,
                    'name' => $comment->user ? $comment->user->names : 'Unknown',
                    'profile' => $comment->user->profile_picture,
                    'replies' => $comment->replies->map(function($reply) {
                        return [
                            'id' => $reply->id,
                            'comment_id' => $reply->comment_id,
                            'reply' => $reply->reply,
                            'created_at' => $reply->created_at,
                            'updated_at' => $reply->updated_at,
                            'user_name' => $reply->user ? $reply->user->names : 'Unknown',
                            'user_profile' => $reply->user ? $reply->user->profile_picture : null,
                        ];
                    })
                ];
            });

        return response()->json($comments);

    }

    public function recommendTo(Request $request, $commentId)
    {
        // Validate incoming request
        $request->validate([
            'user_id' => 'required|exists:staff,id',
            'recommend' => 'nullable|boolean',
        ]);
    
        $userId = $request->input('user_id');
        $recommend = $request->input('recommend');
    
        // Find the comment by ID
        $comment = Comment::findOrFail($commentId);
    
        // Check if recommendation should be canceled
        if ($recommend === false) {
            // Cancel the recommendation
            $comment->recommended_to = null;
            $message = 'Recommendation canceled successfully.';
        } else {
            // Recommend the user
            $comment->recommended_to = $userId;
            $message = 'Recommendation updated successfully.';
        }
    
        $comment->save(); // Save changes
    
        return response()->json(['success' => true, 'message' => $message]);
    }
    

    public function comment_reply(Request $request) {
        $request->validate([
            'comment_id' => 'required',
            'reply' => 'required',
        ]);

        CommentReply::create([
                'comment_id' => $request->comment_id,
                'reply' => $request->reply,
                'user_id' => auth()->guard('staff')->user()->id,
        ]);

        return back();
    }

    public function updateStatus(Request $request, $id)
    {
        $comment = Comment::find($id);
        if ($comment) {
            $comment->status = $request->status;
            $comment->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    // Delete a comment
    public function delete($id)
    {
        $comment = Comment::find($id);
        if ($comment) {
            $comment->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    // Delete a reply
    public function delete_reply($id)
    {
        $reply = CommentReply::find($id);
        if ($reply) {
            $reply->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    public function new_application () {
        return view ('admin.new-application');
    }

    public function post_new_app (Request $request) {
        $request -> validate([
            'app_name' => 'required',
            'org' => 'required',
            'category' => 'required',
            'mode' => 'required',
            'country' => 'required',
            'requirements' => 'required',
            'benefits' => 'required',
            'desc' => 'required',
            'short_desc' => 'required',
            'status' => 'required',
            'specialty' => 'required',
          	'start_date' => 'required',
            'due_date' => 'required',
            // 'price' => 'required',
            'link' => 'required',
          	'link_to_institution' => 'required',
          	//link_to_institution and start_date
            // 'poster' => ['required', 'mimes:jpg,jpeg,png,gif,svg|max:5048'], 
        ]);

        $poster = time().'-'.$request -> file('poster') -> getClientOriginalName();
        $request -> file('poster') -> move(public_path('images/'), $poster);
    
        function identifierGen () {
            return substr(str_shuffle('qazxswedcvfrtgbnhyujmkiolp0123456789'), 0, 8);
        }

        getId:
        $identifier = identifierGen();

        if (DB::table('disciplines') -> where('identifier', $identifier) -> first()) {
            goto getId;
        }

        $data = [
            'identifier' => $identifier, 
            'discipline_name' => $request -> app_name, 
            'organization' => $request -> org, 
            'country' => $request -> country, 
            'category' => $request -> category, 
            'discipline_desc' => $request -> short_desc, 
            'discipline_detailed_desc' => $request -> desc, 
            'poster' => $poster, 
            'includes' => $request -> benefits, 
            'requirements' => $request -> requirements, 
            'status' => $request -> status, 
            'mode' => $request -> mode, 
            'service_fee' => $request -> price, 
            'link' => $request -> link, 
          	'start_date' => $request -> start_date,
          	'website_link' => $request -> link_to_institution,
            'due_date' => $request -> due_date, 
            'speciality' => $request -> specialty
        ];
      
      	$inputs = $request->all();
      
      	if(!DB::table('disciplines') -> where('discipline_name', $request -> app_name) -> exists()){
        
          try{

            DB::table('disciplines') -> insert($data);
            Cache::forget('dashboard_data');
            
            $url = url(route('learnMore', ['discipline_id' => $identifier]));
            $title = $request -> app_name;
            $type = $request -> category;
            $desc = $request -> short_desc;

            $mail_data = [
              'url' => $url,
              'title' => $title,
              'type' => $type,
              'desc' => $desc
            ];

            // Send mails
            // $mail_sender = new MailController();
            // $mail_sender->new_app_mail($receipients, $url, $title, $type, $desc);

            return response()->json([
                'status' => 'success',
                'message' => 'Application created successfully',
                'data' => $mail_data
              ], 201);
          
            // return Auth::user() 
            //   ? redirect() -> route('admin.applications') 
            //   : redirect() -> route('md.apps');
            
          }
        
          catch (\Exception $e) {
            return response()->json([
              'status' => 'error',
              'message' => 'Application created successfully',
              'error' => $e->getMessage()
            ], 500);
          }
        }
      
      	else{
          Session::put('failed', 'Application exists');
          // return back() -> withInput($inputs);
          return response()->json([
            'status' => 'error',
            'message' => 'Application exists',
          ], 400);
        }
    }

    public function edit_app(Request $request) {
        $request->validate([
            'app_id' => ['required'],
            'app_name' => ['required'],
            'org' => ['required'],
            'category' => ['required'],
            'mode' => ['required'],
            'country' => ['required'],
            'requirements' => ['required'],
            'benefits' => ['required'],
            'desc' => ['required'],
            'status' => ['required'],
            'specialty' => ['required'],
            'due_date' => ['required'],
            // 'price' => ['required'],
          'link' => ['required'],
            // 'poster' => ['required', 'mimes:jpg,jpeg,png,gif,svg|max:5048'],
        ]);

        if($request -> hasFile('poster')) {

            $poster = time().'-'.$request -> file('poster') -> getClientOriginalName();

            if (File::exists(public_path('images/'.$request -> old_poster))) {
                File::delete(public_path('images/'.$request -> old_poster));
            }
                $request -> file('poster') -> move(public_path('images/'), $poster);
    
                $data = [
                    'discipline_name' => $request -> app_name, 
                    'organization' => $request -> org, 
                    'country' => $request -> country, 
                    'category' => $request -> category, 
                    'discipline_desc' => $request -> short_desc, 
            		    'discipline_detailed_desc' => $request -> desc,  
                    'poster' => $poster, 
                    'includes' => $request -> benefits, 
                    'requirements' => $request -> requirements, 
                    'status' => $request -> status, 
                    'mode' => $request -> mode, 
                    'service_fee' => $request -> price, 
                    'due_date' => $request -> due_date, 
                    'speciality' => $request -> specialty,
                  	'link' => $request -> link, 
                  	'website_link' => $request -> link_to_institution, 
                ];  
                
                DB::table('disciplines') -> where('id', $request -> app_id) -> limit(1) -> update($data);
        
            }

        else {
            $data = [
                'discipline_name' => $request -> app_name, 
                'organization' => $request -> org, 
                'country' => $request -> country, 
                'category' => $request -> category, 
                'discipline_desc' => $request -> short_desc, 
            	  'discipline_detailed_desc' => $request -> desc,  
                'includes' => $request -> benefits, 
                'requirements' => $request -> requirements, 
                'status' => $request -> status, 
                'mode' => $request -> mode, 
                'service_fee' => $request -> price, 
                'due_date' => $request -> due_date, 
                'speciality' => $request -> specialty,
              	'link' => $request -> link, 
                'website_link' => $request -> link_to_institution, 
            ];  
            DB::table('disciplines') -> where('id', $request -> app_id) -> limit(1) -> update($data);
        }

        return back();
    }

    public function delete_application(Request $request) {
        $app = DB::table('disciplines') -> where('id', $request -> app_id) -> first();
        if(DB::table('disciplines') -> where('id', $request -> app_id) -> limit(1) -> delete()) {
            File::delete(public_path('images/'.$app -> poster));
            return view('admin.delete-app-resp', compact('app'));
        }
        else {
            return to_route('admin.applications');
        }
    }

    public function AppRequests() {
        $requests = DB::table('user_requests') -> get();
        return view('admin.user-requests', compact('requests'));
    }

    public function requestsReview(Request $request) {

        if (DB::table('user_requests') -> where('application_id', $request -> app_id) -> exists()) {
            $request_info = DB::table('user_requests') -> where('application_id', $request -> app_id) -> first();
        }

        else {
            $request_info = DB::table('served_requests') -> where('application_id', $request -> app_id) -> first();
        }

        $edu_info = DB::table('applicant_education_info') -> where('applicant', $request_info -> id) -> get();
        $client_documnent = DB::table('applicant_documents') -> where('applicant', $request_info -> id) -> get();
        return view('admin.request-review', compact('request_info', 'edu_info', 'client_documnent'));
    }

}