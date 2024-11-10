<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use App\Models\Applicant_info;
use Illuminate\Http\Request;
use App\Mail\RequestReceived;
use DB;
use Auth; 
use Session;
use Mail;

class UserRequestController extends Controller {
  
  	public function apply (Request $request) {
        $discipline_info = DB::table('disciplines') -> where('identifier', $request -> discipline_id) -> first();
      
      	if (isset($_COOKIE['user_email']) || isset($_COOKIE['user_phone'])) {
          
          $applicant_data = [
              'names' => $_COOKIE['user_names'],
              'email' => $_COOKIE['user_email'],
              'phone_number' => $_COOKIE['user_phone'],
          ];
          
          if(!DB::table('applicant_info') -> where('email', $_COOKIE['user_email']) -> exists()) {
            DB::table('applicant_info') -> insert($applicant_data);
          }
          
          $applicant_info = DB::table('applicant_info') -> where('email', $_COOKIE['user_email']) -> first();

          $application_info = [
              'applicant' => $applicant_info -> id,
              'discipline_id' => $discipline_info -> id,
          ];
          
          if(DB::table('applications') -> where('applicant', $applicant_info -> id) -> where('discipline_id', $discipline_info ->id)->exists()){
          
            Session::put('exist', 'You already have requested this application!');
            
            return back();
            
          }
                
          elseif(DB::table('applications') -> insert($application_info)) {
          
              $url = url(route('login', ['user_email' => $_COOKIE['user_email']]));
            
              $user = $_COOKIE['user_names'];

              $app = $discipline_info -> discipline_name;

              $application = DB::table('applications') -> where('applicant', $applicant_info -> id) -> select('app_id') -> first();

              Session::put('scss', 'Your request was successfully sent!');

              if (!Auth::guard('client') -> user()) 
                $applicantId = Crypt::encrypt($applicant_info -> id);

                  Mail::to($_COOKIE['user_email']) -> send(new RequestReceived($url, $user, $app));

                  return redirect() -> route('follow-up', ['discipline' => $discipline_info -> identifier, 'app_id' => $request -> app_id, 'applicant' => $applicantId]);

              Mail::to($_COOKIE['user_email']) -> send(new RequestReceived($url, $user, $app)); 

              return redirect() -> route('client.client-dashboard');

          }

          else {
            
            	Session::put('failed_req', 'There was an error sending your request, please');
              	return back();
          }

        }

      else {
        return view('apply', compact('discipline_info'));
      }
    }

    public function user_request_application(Request $request) {

      // Validate request data
      $validateData = $request->validate([
          'application_info' => ['required'],
          'names' => ['required'],
          'email' => ['required', 'max:255'],
          'phone_number' => ['required'],
      ]);
  
      $applicant_data = [
          'names' => $request->names,
          'email' => $request->email,
          'phone_number' => $request->phone_number,
      ];
  
      // Set cookies if not already set
      if (!isset($_COOKIE['user_email']) || !isset($_COOKIE['user_phone'])) {
          setcookie('user_names', $request->names, time() + (24 * 3600), "/", 'www.bscholarz.com');
          setcookie('user_email', $request->email, time() + (24 * 3600), "/", 'www.bscholarz.com');
          setcookie('user_phone', $request->phone_number, time() + (24 * 3600), "/", 'www.bscholarz.com');
      }
  
      // Check if applicant already exists
      if (!DB::table('applicant_info')->where('email', $request->email)->exists()) {
          DB::table('applicant_info')->insert($applicant_data);
      }
  
      $applicant_info = DB::table('applicant_info')->where('email', $request->email)->first();
  
      $application_info = [
          'applicant' => $applicant_info->id,
          'discipline_id' => $request->application_info,
      ];
  
      $discipline_identifier = DB::table('disciplines')->where('id', $request->application_info)->first();
  
      // Add to subscribers if not already subscribed
      if (!DB::table('subscribers')->where('email', $request->email)->exists()) {
          DB::table('subscribers')->insert([
              'names' => $request->names,
              'email' => $request->email,
          ]);
  
          if (!isset($_COOKIE['client_email'])) {
              setcookie('client_email', $request->email, time() + (365 * 24 * 60 * 60), "/", 'www.bscholarz.com');
          }
      }
  
      // Check if application already exists for this discipline
      if (DB::table('applications')->where('applicant', $applicant_info->id)
          ->where('discipline_id', $discipline_identifier->id)->exists()) {
  
          Session::put('exist', 'You already have requested this application!');
          return back();
      } else {
          // Insert the application and get the ID of the new record
          $application_id = DB::table('applications')->insertGetId($application_info);
      }
  
      // Prepare email and URL
      $url = url(route('login', ['user_email' => $request->email]));
      $app = $discipline_identifier->discipline_name;
  
      // Send notification email
      Mail::to($request->email)->send(new RequestReceived($url, $request->names, $app));
  
      // Set success message
      Session::put('scss', 'Your request was successfully sent!');

      $encryptedApplicationId = Crypt::encryptString($application_id);
  
      // Redirect to the app-payment route with the application ID
      return redirect()->route('app-payment', [
          'discipline' => $discipline_identifier->id,
          'client' => $request->names,
          'client_phone' => $request->phone_number,
          'application_id' => $encryptedApplicationId,
        ]);
  }  
  
}