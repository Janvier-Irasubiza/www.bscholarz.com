<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\Models\Discipline;
use App\Models\Applicant_info;
use App\Models\Request as Applications;

class PaymentsController extends Controller
{
    public function payment_view(Request $request) {

      $application_id = Crypt::decryptString($request->application_id);

      $service = Discipline::where('id', $request->discipline)
                          ->select('id', 'identifier', 'discipline_name', 'organization', 'country', 'category')
                          ->first();

      $client_id = Applications::where('app_id', $application_id)
                          ->select('applicant')
                          ->first();
      
      $amount = 15000;
      $client = $request->client;
      $client_phone = $request->client_phone;
      $application = $request->application_id;

      return view('payment', compact('service', 'amount', 'client', 'client_id', 'client_phone', 'application'));
    }

    public function service_payment_view(Request $request) {

      $service = Discipline::where('identifier', $request->app)
                          ->select('id', 'identifier', 'discipline_name', 'organization', 'country', 'category')
                          ->first();
      
      $amount = 15000;
      return view('service-payment', compact('service', 'amount',));
    }

    public function formatPhoneNumber($phoneNumber) {
      // Remove any spaces from the phone number
      $phoneNumber = str_replace(' ', '', $phoneNumber);
  
      // Check if the phone number starts with '+250' and convert to local format
      if (Str::startsWith($phoneNumber, '+250')) {
          $phoneNumber = '0' . substr($phoneNumber, 4);
      }
      
      // Ensure the number starts with '0' after formatting
      if (!Str::startsWith($phoneNumber, '0')) {
          return 1;
      }
  
      // Validate the phone number length (assuming it should be 10 digits)
      if (strlen($phoneNumber) !== 10) {
        return null;
      }
  
      return $phoneNumber;
  }
  

    public function getApiKey($phoneNumber) {
      if (Str::startsWith($phoneNumber, ['078', '079'])) {
          // Use the MTN API key
          $apiKey = env('MTN_API_KEY');
      } elseif (Str::startsWith($phoneNumber, ['072', '073'])) {
          // Use the Airtel API key
          $apiKey = env('AIRTEL_API_KEY');
      } else {
          // Handle invalid phone number case
          return null;
      }
  
      // Return the API key
      return $apiKey;
    }
  
    public function pay(Request $request) {

      // Validate inputs
      $validatedData = $request->validate([
        'app_id' => 'required|string|min:0',
        'identifier' => 'required|string|min:0',
        'applicant' => 'required|integer|min:0',
        'amount' => 'required|integer|min:0',
        'phone' => 'required|string|max:30',
        'payment_method' => 'required|string|max:255',
      ]);

      // Decrypt app_id
      $app_id = Crypt::decryptString($validatedData['app_id']);
      $phoneNumber = $this->formatPhoneNumber($validatedData['phone']);

      if ($phoneNumber === null) {
          return response()->json(['message' => 'Phone number must be 10 digits long after formatting.'], 400);
      }

      if ($phoneNumber === 1) {
        return response()->json(['message' => 'Invalid phone number'], 400);
      }

      $apiKey = $this->getApiKey($phoneNumber);

      if ($apiKey === null) {
        return response()->json(['message' => 'Invalid phone number prefix'], 400);
      }

      // Prepare api data
      $data = array(
        'amount' => $validatedData['amount'],
        'phone' => $phoneNumber,
        'key' => $apiKey
      );

      $encData = json_encode($data);
      // Initialize curl
      $curl = curl_init();

      // Set curl options
      curl_setopt($curl, CURLOPT_URL, 'https://pay.itecpay.rw/api/pay');
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $encData);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
          
      // Execute the request
      $response = curl_exec($curl);

      if (curl_errno($curl)) {
        $error = curl_error($curl);
        return response()->json(['message' => 'Something went wrong'], 500);
      }

      // Close the curl session
      curl_close($curl);

      // Output the response
      $responseData = json_decode($response, true);

      if (is_null($responseData)) {
        return response()->json([
            'message' => 'Operation Failed, Try again!'
        ], 500);
      }

      $status = $responseData['status'];
          
      if($status===200){
          $amount = $responseData['data']['amount'];
          $uniqueId = $responseData['data']['transID'];
          $app = Applications::find($app_id);
          $app->transaction_id = $uniqueId;
          $app->save();

          $client = Applicant_info::where('uuid', $validatedData['applicant'])
          ->select('uuid')
          ->first();

          Session::put('client', $client);

          return response()->json([
            'status' => $status,
            'message' => 'Payment successful',
          ]);
      }
      else{
        return response()->json([
          'status' => $status,
          'message' => $responseData['data']['message']
        ]);
      }
    }

    public function link_pay(Request $request) {
      // Validate inputs
      $validatedData = $request->validate([
        'identifier' => 'required|string|min:0',
        'amount' => 'required|integer|min:0',
        'phone' => 'required|string|max:30',
        'payment_method' => 'required|string|max:255',
      ]);

      $phoneNumber = $this->formatPhoneNumber($validatedData['phone']);
      if ($phoneNumber === null) {
          return response()->json(['message' => 'Phone number must be 10 digits long after formatting.'], 400);
      }
      if ($phoneNumber === 1) {
        return response()->json(['message' => 'Invalid phone number'], 400);
      }
      $apiKey = $this->getApiKey($phoneNumber);
      if ($apiKey === null) {
        return response()->json(['message' => 'Invalid phone number prefix'], 400);
      }

      // Prepare api data
      $data = array(
        'amount' => 10,
        'phone' => $phoneNumber,
        'key' => $apiKey
      );
      $encData = json_encode($data);
      
      // Initialize curl
      $curl = curl_init();

      // Set curl options
      curl_setopt($curl, CURLOPT_URL, 'https://pay.itecpay.rw/api/pay');
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $encData);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

      // Execute the request
      $response = curl_exec($curl);
      if (curl_errno($curl)) {
        $error = curl_error($curl);
        return response()->json(['message' => 'Something went wrong'], 500);
      }

      // Close the curl session 
      curl_close($curl);

      // Output the response
      $responseData = json_decode($response, true);

      if (is_null($responseData)) {
        return response()->json([
            'message' => 'Operation Failed, Try again!'
        ], 500);
      }

      $status = $responseData['status'];

      if($status===200){
          $amount = $responseData['data']['amount'];
          $uniqueId = $responseData['data']['transID'];
          $service = Discipline::where('identifier', $validatedData['identifier'])->first();

          Session::put('service_link', $service->link);

          return response()->json([
            'status' => $status,
            'message' => 'Payment successful',
          ]);
      } else {
          return response()->json([
            'status' => $status,
            'message' => $responseData['data']['message']
          ]);
        }
    }

      public function payment(Request $request) {
        return redirect()->route('request.payment', [
          'service' => $request->input('application_info'),
          'amount' => $request->input('amount'),
          'client' => $request->input('names')
        ]);
      }

      public function pay_view($request) {
        $service = Discipline::where('id', $request->input('application_info'))
                            ->select('id', 'identifier', 'discipline_name', 'organization', 'country', 'category')
                            ->first();
    
        $amount = 15000;
        $client = $request->input('names');
    
        // Save data or perform other logic here...
    
        // Store data in session to retrieve it after redirecting
        session([
            'service' => $service,
            'amount' => $amount,
            'client' => $client
        ]);
    
        // Redirect to a confirmation page after processing
        return view('payment', compact('service', 'amount', 'client'));
      }

      public function confirmation() {

        $client = session('client');
        $applicant = Applicant_info::where('uuid', $client)->first();

        // Display the confirmation view with session data
        return view('follow-up', compact('applicant'));
      }

      public function confirm(Request $request) {

        // Retrieve the data from the session
        $link = session('service_link');

        // Display the confirmation view with session data
        return view('confirmation', compact('link'));
      }

    

      public function approve_payment(Request $request) {
        
          $validator = Validator::make($request->all(), [
              'app_id' => 'required|integer|min:0',
              'identifier' => 'required|string|min:0',
              'applicant' => 'required|integer|min:0',
              'amount' => 'required|integer|min:0',
              'phone' => 'required|string|min:10|max:12',
              'payment_method' => 'required|string|max:255',
          ]);
        
          $client = DB::table('served_requests') -> where('application_id', $request -> app_id) -> where('id', $request -> applicant) -> first();
        
          if ($request->payment_method == 'momo') {
              $bankid = '63510';
              $payment_number = $request -> phone;
              if ($validator->fails()) {
                  return back() 
                    -> withInput($request->input())
                    ->with('phone', 'The Phone number must not be greater than 12 characters.');
              }
          }
          else{
              $payment_number = $request -> phone;
              $bankid = '000';
          }
        
          $phone = $request -> phone;
        
          if (substr(preg_replace('/[^0-9]/', '', $phone),0,4)=='2507' && strlen($phone)==12) {
              $phone = $phone;
              $rightphone = true;
          }
          else {
              if (substr(preg_replace('/[^0-9]/', '', $phone),0,2)=='07' && strlen($phone)==10) {
                  $phone = '25'.$phone;
                  $rightphone = true;
              }
              else {
                  $rightphone = false;
              }
          }
          if (!$rightphone) {
            
            return back() 
                    -> withInput($request->input())
                    ->with('phone', 'Invalid phone number. 07********');
          }
              
          function refIdGen () {
              return time().''.rand(100,999).''.rand(1000,9999);
          }

          getId:
          $refid = refIdGen();

          if (DB::table('applications') -> where('payment_id', $refid) -> first()) {
              goto getId;
          }
        
          $returl = url(route('pay-callback'));
          $redirecturl = '';
        
          if ($request->payment_method == 'cc') {
            $redirecturl = url(route('finish', [
            'discipline' => $request -> identifier, 
            'app_id' => $request -> app_id,  
            'applicant' => $request -> applicant,
            'message' => 'Your payment was successfully received by BSholarz.',
            'subcontent' => 'Thank you for working with us.',
          ]));
          }
        
        else {
          $redirecturl = url(route('finish', [
              'discipline' => $request -> identifier, 
              'app_id' => $request -> app_id,  
              'applicant' => $request -> applicant,
            ]));
        }
        
          $request_data = array(
              'action' => 'pay',
              'msisdn' => $phone,
              'details' => $client -> discipline_name.' Payment',
              'refid' => $refid,
              'amount' => $request -> amount,
              'currency' => 'RWF',
              'email' => $client -> email, 
              'cname' => $client -> names,
              'cnumber' => $client -> phone_number,
              'pmethod' => $request -> payment_method,
              'retailerid' => '01',
              'returl' => $returl,
              'redirecturl' => $redirecturl,
          );
        
          Session::put('payment_id', $refid);
        
          $json_data = json_encode($request_data);
          $ch = curl_init('https://pay.esicia.com');
        
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
          curl_setopt($ch, CURLOPT_USERPWD, 'BSCHOLARZ:5Glx5m');

          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

          // Send the JSON data to the server
          $responses = curl_exec($ch);
        
          DB::table('applications') -> where('app_id', $request -> app_id) -> where('applicant', $request -> applicant) -> update(['payment_id' => $refid, 'payment_status' => 'Pending']);
        
          // Check for errors
          if(curl_errno($ch)) {
            // echo 'Error: ' . curl_error($ch);
            return back() 
            -> withInput($request->input())
            ->with('phone', 'Something went wrong, please try again');
          }

          // Close the cURL session
          curl_close($ch);
        
          /*  try {
              return response() -> json([
                  'status' => true,
                  'message' => $responses,
              ], 201);
          } catch (\Exception $e) {
              return response() -> json([
                  'status' => false,
                  'message' => 'An error occured.',
                  'error' => $e -> getMessage()
              ], 500);
          } */
        
        $returnedData = json_decode($responses, true);
        
        if($request->payment_method == 'cc') {
          if($returnedData['url'] != '') {
            return redirect()->away($returnedData['url']);
          }
        }
        
        else{
          
        if($returnedData['retcode'] == 01 || $returnedData['retcode'] == 0) {
          
          // Update applications with payment ID
          DB::table('applications') -> where('app_id', $request -> app_id) -> where('applicant', $request -> applicant) -> update(['payment_id' => $refid, 'payment_status' => 'Pending']);
          
          
          if (!Auth::guard('client') -> user()) {
            return redirect() -> route('finish', ['discipline' => $request -> identifier, 'app_id' => $request -> app_id,  'applicant' => $request -> applicant]);
        } 

          else {
            return redirect() -> route('client.client-dashboard');
        }
          
        }
        
        elseif($returnedData['retcode'] == 03) {
          
          // Update applications with payment ID
          DB::table('applications') -> where('app_id', $request -> app_id) -> where('applicant', $request -> applicant) -> update(['payment_id' => $refid, 'payment_status' => 'Pending']);
          
        
          if (!Auth::guard('client') -> user()) {
            return redirect() -> route('finish', ['discipline' => $request -> identifier, 'app_id' => $request -> app_id,  'applicant' => $request -> applicant]);
        } 

          else {
            return redirect() -> route('client.client-dashboard');
        }
          
        }
        
        elseif($returnedData['retcode'] == 606 && $returnedData['statusmsg'] == 'Not enough funds') {
        
          return back() 
            -> withInput($request->input())
            ->with('phone', "You do not have enough funds. Consider recharging or use a different phone number.");
          
        } 
          else {
        
          return back() 
            -> withInput($request->input())
            ->with('phone', 'Something went wrong try again');
          
        } 
        
        } 
        
      }
    
    public function show() {
      return view('resp');
    }
  
  public function handle_callback(Request $request) {
    
    $validateData = $request -> validate([
            'refid' => ['required'],
        ]);
    
		date_default_timezone_set('Africa/Kigali');

       	/** $cancel_url = route('project.kpay.cancel'); **/
    
        /** Get the payment ID before session clear **/
        // $refId = Session::get('payment_id');
    
    	$fields = array(
          "action" => "checkstatus",
          "tid" => $request->tid,
          "refid" => $request->refid,
        );

        $curl = curl_init('https://pay.esicia.com');
    
    	curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic Zm9ydHVuZTpGb3J0dW5lMUAuMkAu', 'Content-Type: application/json'));
    
        /* curl_setopt_array($curl, array(
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => '{ 
          				"action":"checkstatus",
                      	"refid":"'.$request->refid.'",
                      }',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Basic Zm9ydHVuZTpGb3J0dW5lMUAuMkAu',
            'Content-Type: application/json',
          ),
        )); */

        $response = curl_exec($curl);
    
    	return response() -> json([
                'response' => $response,
            ]);
    

        $resp = json_decode($response, true);

        if ($resp['statusid'] == '02') {
          return redirect() -> route('home');
        }
    
          
            if ($resp['statusid'] = '01') {
              
                // update the payment_status to 'success'
                DB::table('applications') -> where('payment_id', $refId) -> update(['payment_status' => 'Paid', 'payment_date' => Carbon::now()->format('Y-m-d H:i:s.u'), 'outstanding_amount' => 0]);
            
            }
          
            elseif ($resp['statusid'] = '02') {
              
                DB::table('applications') -> where('payment_id', $refId) -> update(['payment_status' => 'Failed']);
            
            }
          
            else{
              
                DB::table('applications') -> where('payment_id', $refId) -> update(['payment_status' => 'Pending']);
            
            }

            return response()->json([
              
                'message' => 'Payment callback received successfully.',
              
            ]);
          
        } 
    
  }
  

