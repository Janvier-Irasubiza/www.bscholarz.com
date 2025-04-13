<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Notifications;
use App\Http\Controllers\Utils;
use App\Models\Request as Applications;
use App\Models\Applicant_info;
use App\Models\Staff;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Mail\RequestReceived;
use App\Mail\NotifyStaff;
use DB;
use Auth;
use Session;
use Mail;
use App\Jobs\SendSmsJob;
use Illuminate\Support\Facades\Log;

class UserRequestController extends Controller
{

  public function apply(Request $request)
  {
    $discipline_info = DB::table('disciplines')->where('identifier', $request->discipline_id)->first();
    return view('apply', compact('discipline_info'));
  }

  public function user_request_application(Request $request)
  {

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
    $applicant_info = Applicant_info::where('email', $request->email)->first();

    if (!$applicant_info) {
      $applicant_info = Applicant_info::create($applicant_data);
    }

    $application_info = [
      'applicant' => $applicant_info->id,
      'discipline_id' => $request->application_info,
    ];

    $discipline_identifier = DB::table('disciplines')->where('id', $request->application_info)->first();

    // Add to subscribers if not already subscribed
    if (!Subscriber::where('email', $request->email)->exists()) {
      Subscriber::create([
        'names' => $request->names,
        'email' => $request->email,
      ]);

      if (!isset($_COOKIE['client_email'])) {
        setcookie('client_email', $request->email, time() + (365 * 24 * 60 * 60), "/", 'www.bscholarz.com');
      }
    }

    // Check if application already exists for this discipline
    if (
      Applications::where('applicant', $applicant_info->id)
        ->where('discipline_id', $discipline_identifier->id)
        ->exists()
    ) {
      Session::put('exist', 'You already have requested this application!');
      return back();
    } else {
      // Insert the application and get the ID of the new record
      $application = Applications::create($application_info);
      $application_id = $application->app_id;
    }

    // Prepare email and URL
    $url = url(route('login', ['user_email' => $request->email]));
    $app = $discipline_identifier->discipline_name;

    // Send notification email
    Mail::to($request->email)->send(new RequestReceived($url, $request->names, $app));

    // Set success message
    Session::put('scss', 'Your request was successfully sent!');

    // Notify staff of new application
    // Get the staff emails
    $staffs = Staff::whereHas('department', function ($query) {
        $query->where('name', '!=', 'Marketing'); // Exclude Marketing department
    })
    ->select('email', 'phone_number') // Ensure columns are selected
    ->pluck('phone_number', 'email') // Keep email as key, phone_number as value
    ->toArray();

    $smsNotification = new Notifications();

    Log::info('contacts: '. json_encode(array_values($staffs)));

    // Queue email notifications for each staff
    foreach ($staffs as $email => $phone) { 
      $details = [
          'subject' => 'New Application Request',
          'email' => $email,
          'message' => 'A new application request has been made for ' . $app . ' by ' . $request->names . '. Kindly login to the admin dashboard to view the details.',
          'url' => route('staff-dashboard'),
      ];

      // Queue the email notification
      Mail::to($email)->queue(new NotifyStaff($details));
    }

    // Prepare SMS data (Send once for all recipients)
    $smsData = [
      'key' => $smsNotification->getSmsApiKey(),
      'message' => 'A new application request has been made for ' . $app . ' by ' . $request->names . '. Kindly login to the admin dashboard to view the details. ' . route('staff-dashboard'),
      'recipients' => array_values($staffs), // Send SMS to all non-marketing staff
    ];

    // Dispatch the SMS job only once (Outside the loop)
    dispatch(new SendSmsJob($smsData));

    $encryptedApplicationId = Crypt::encryptString($application_id);

    // Redirect to the app-payment route with the application ID
    return redirect()->route('app-payment', [
      'discipline' => $discipline_identifier->id,
      'client' => $request->names,
      'client_phone' => $request->phone_number,
      'email' => $request->email,
      'application' => $request->application_info,
      'application_id' => $encryptedApplicationId,
      'r_type' => 'request_service',
    ]);
  }

  public function book_appointment(Request $request)
  {

    // Validate request data
    $validateData = $request->validate([
      'application_info' => ['required'],
      'names' => ['required'],
      'email' => ['required', 'max:255'],
      'phone_number' => ['required'],
      'time' => ['required'],
      'address' => ['required', 'string'],
    ]);

    $applicant_data = [
      'names' => $validateData['names'],
      'email' => $validateData['email'],
      'phone_number' => $validateData['phone_number'],
    ];

    // Set cookies if not already set
    if (!isset($_COOKIE['user_email']) || !isset($_COOKIE['user_phone'])) {
      setcookie('user_names', $request->names, time() + (24 * 3600), "/", 'www.bscholarz.com');
      setcookie('user_email', $request->email, time() + (24 * 3600), "/", 'www.bscholarz.com');
      setcookie('user_phone', $request->phone_number, time() + (24 * 3600), "/", 'www.bscholarz.com');
    }

    // Check if applicant already exists
    $applicant_info = Applicant_info::where('email', $request->email)->first();

    if (!$applicant_info) {
      $applicant_info = Applicant_info::create($applicant_data);
    }

    $application_info = [
      'applicant' => $applicant_info->id,
      'discipline_id' => $request->application_info,
      'time' => $validateData['time'],
      'address' => $validateData['address'],
      'is_appointment' => true,
    ];

    $discipline_identifier = Discipline::where('id', $validateData['application_info'])->first();

    // Add to subscribers if not already subscribed
    if (!Subscriber::where('email', $request->email)->exists()) {
      Subscriber::create([
        'names' => $request->names,
        'email' => $request->email,
      ]);

      if (!isset($_COOKIE['client_email'])) {
        setcookie('client_email', $request->email, time() + (365 * 24 * 60 * 60), "/", 'www.bscholarz.com');
      }
    }

    // Check if application already exists for this discipline
    if (
      Applications::where('applicant', $applicant_info->id)
        ->where('discipline_id', $discipline_identifier->id)
        ->exists()
    ) {
      Session::put('exist', 'You already have requested this application!');
      return back();
    } else {
      // Insert the application and get the ID of the new record
      $application = Applications::create($application_info);
      $application_id = $application->app_id;
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
      'client' => $validateData['names'],
      'client_phone' => $validateData['phone_number'],
      'application_id' => $encryptedApplicationId,
      'r_type' => 'book_appointment',
    ]);
  }

}