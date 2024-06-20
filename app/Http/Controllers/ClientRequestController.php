<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\RequestReceived;
use DB;
use Session;
use Mail;

class ClientRequestController extends Controller {

    public function client_application (Request $request) {
      
      $user = DB::table('applicant_info') -> where('id', Auth::guard('client') -> user() -> id) -> first();

        $application_info = [
            'applicant' => Auth::guard('client') -> user() -> id,
            'discipline_id' => $request -> application_info,
        ];
      
      	if(DB::table('applications') -> where('applicant', Auth::guard('client') -> user() -> id) -> where('discipline_id', $request -> application_info)->exists()){
          
            Session::put('exist', 'You already have requested this application!');
            
            return back();
            
          }

        else {
          $new_app = DB::table('applications') -> insertGetId($application_info);
        $discipline_identifier = DB::table('disciplines') -> where('id', $request -> application_info) -> first(); 

      	$url = url(route('client.client-dashboard'));
      	$app = $discipline_identifier -> discipline_name;
      
        if (!Auth::guard('client') -> user()) {
          
          // Mail::to($user -> email) -> send(new RequestReceived($url, $user -> names, $app));
           
          return redirect() -> route('follow-up', ['discipline' => $request -> identifier, 'app_id' => $request -> app_id,  'applicant' => $request -> applicant]);
        }

        else {
          
          	// Mail::to($user -> email) -> send(new RequestReceived($url, $user -> names, $app));
          
            Session::put('scss', 'Your request was successfully sent!');
              return redirect() -> route('client.client-dashboard');
          }

        // return redirect() -> route('app-payment', ['discipline' => $discipline_identifier -> identifier, 'app_id' => $new_app,  'applicant' => Auth::guard('client') -> user() -> id]);

        }
    }

}