<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\Comment;
use File; 
use Illuminate\Http\Request;
use DB;
use Mail;
use App\Mail\Post;
use Session;
use App\Http\Controllers\MailController;

class ApplicationsController extends Controller {

    public function applications () {
      $applications = DB::table('disciplines')
      ->where('category', '<>', 'Custom')
      ->orderBy('publish_date', 'ASC')
      ->get();
  
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

    public function comments() {
      $comments = Comment::with('user')
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
                'profile' => $comment->user->profile_picture
            ];
        });
        return response()->json($comments);
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
        
          if(DB::table('disciplines') -> insert($data)){
          
          $receipients = [];
          
          $users = DB::table('applicant_info') -> get();
          $subs = DB::table('subscribers') -> get();
          
          $url = url(route('learnMore', ['discipline_id' => $identifier]));
          $title = $request -> app_name;
          $type = $request -> category;
          $desc = $request -> short_desc;
          
          foreach($users as $user) {
          
            array_push($receipients, [
            
              'email' => $user -> email, 
              
            ]);
            
          }
          
          foreach($subs as $sub) {
          
            array_push($receipients, [
            
              'email' => $sub -> email, 
              
            ]);
            
          }

          // Send mails
          $mail_sender = new MailController();
          $mail_sender->send_mail($receipients, $url, $title, $type, $desc);
        
           return redirect() -> route('admin.applications');
          
        }
      
      else {
      
        return back() -> withInput($inputs);
        
      }
          
        }
      
      	else{
          
          Session::put('failed', 'Application exists');
        
          return back() -> withInput($inputs);
          
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