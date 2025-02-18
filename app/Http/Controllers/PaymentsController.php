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
use App\Models\SubscriberSubscription;
use App\Models\Applicant_info;
use App\Models\Subscriber;
use App\Models\Costs;
use App\Models\Request as Applications;
use App\Models\GeneralPayments;
use Mail;
use App\Mail\AppLinkMail;
use App\Mail\UserNotification;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendSmsJob;

class PaymentsController extends Controller
{

  public function payTest() {
    $this->TestPayment();
  }

  private function TestPayment()
{
    // Define API request data
    $data = [
        'amount' => 10.00,
        'phone' => "0781336634",
        'key' => $this->getApiKey('0781336634')
    ];

    // Encode data to JSON format
    $encData = json_encode($data);
    Log::info('requestDtata: ' . $encData);

    // Initialize cURL
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $this->getApiUrl());
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $encData);
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    // Execute the request
    $response = curl_exec($curl);

    // Check for errors
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
        curl_close($curl);
        
        Log::error("Payment API Request Failed: " . $error_msg);
        return response()->json(['message' => 'Payment request failed', 'error' => $error_msg], 500);
    }

    curl_close($curl);

    // Decode JSON response
    $decodedResponse = json_decode($response, true);

    if (!$decodedResponse) {
        Log::error("Invalid JSON response from API: " . $response);
        return response()->json(['message' => 'Invalid response from API'], 500);
    }

    return response()->json(['message' => 'Payment request successful', 'data' => $decodedResponse]);
}


  public function payment_view(Request $request)
  {

    $application_id = Crypt::decryptString($request->application_id);

    $service = Discipline::findOrFail($request->discipline);

    $request_info = Applications::where('app_id', $application_id)
      ->select('applicant', 'is_appointment', 'time', 'address')
      ->first();

    $text = $request->r_type == 'book_appointment' ? 'appointment' : '';

    $amount = Costs::where('service', $request->r_type)->value('cost');
    $client = $request->client;
    $client_phone = $request->client_phone;
    $application = $request->application_id;

    return view('payment', compact('service', 'amount', 'client', 'request_info', 'client_phone', 'application', 'text'));
  }

  public function service_payment_view(Request $request)
  {

    $service = Discipline::where('identifier', $request->app)
      ->select('id', 'identifier', 'discipline_name', 'organization', 'country', 'category')
      ->first();

    $amount = Costs::where('service', $request->r_type)->value('cost');
    return view('service-payment', compact('service', 'amount', ));
  }

  private function formatPhoneNumber($phoneNumber)
  {
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

  private function getApiUrl()
  {
    return env('PAYMENT_API_URL');
  }

  private function getApiKey($phoneNumber = null)
  {
    $apiKey = env('CARD_API_KEY');

    if ($phoneNumber) {
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
    }

    // Return the API key
    return $apiKey;
  }

  // public function pay(Request $request)
  // {
  //     try {
  //         // Validate input
  //         $validatedData = $request->validate([
  //             'app_id' => 'required|string|min:0',
  //             'identifier' => 'required|string|min:0',
  //             'applicant' => 'required|integer|min:0',
  //             'amount' => 'required|numeric|min:0',
  //             'phone' => 'required_if:payment_method,momo|string|max:30',
  //             'payment_method' => 'required|string|max:10',
  //         ]);

  //         // Decrypt and validate app_id
  //         try {
  //             $app_id = Crypt::decryptString($validatedData['app_id']);
  //             $app = Applications::findOrFail($app_id); // Throws 404 if not found
  //         } catch (\Exception $e) {
  //             return response()->json(['message' => 'Invalid application ID'], 400);
  //         }

  //         // Format phone number if payment method is MoMo
  //         $phoneNumber = $validatedData['payment_method'] === 'momo'
  //             ? $this->formatPhoneNumber($validatedData['phone'])
  //             : null;

  //         // Format the phone number
  //         $phone = $this->formatPhoneNumber($request->phone);

  //         // Get the API key based on the payment method
  //         $apiKey = $request->payment_method == 'momo'
  //             ? $this->getApiKey($phone)
  //             : $this->getApiKey();

  //         // Get API key based on payment method
  //         $apiKey = $validatedData['payment_method'] === 'momo'
  //             ? $this->getApiKey($phone)
  //             : $this->getApiKey();

  //         // Prepare API data
  //         $paymentData = [
  //             'amount' => $validatedData['amount'],
  //             'phone' => $phone,
  //             'key' => $apiKey,
  //         ];

  //         // Send the payment request
  //         $response = $this->sendPaymentRequest($paymentData);
  //         Log::info('Payment API Request: ' . json_encode($paymentData));
  //         // Log::info('Payment API Response: ' . json_encode($response));

  //         if (!$response) {
  //             return response()->json(['message' => 'Operation Failed, Try again!'], 500);
  //         }

  //         if ($response['status'] !== 200) {
  //             return response()->json([
  //                 'status' => 400,
  //                 'message' => $response['data']['message'] ?? 'Payment Failed.',
  //             ]);
  //         }

  //         // Fetch client details
  //         $client = Applicant_info::where('id', $validatedData['applicant'])
  //             ->select('uuid', 'names', 'email')
  //             ->first();

  //         Session::put('client', $client);

  //         $subscriber = Subscriber::where('email', $client->email)
  //             ->select('id')
  //             ->first();

  //         // Send SMS notification
  //         $this->sendPaymentNotifications($client, $phoneNumber);

  //         // Handle payment response and return proper response
  //         return $this->handlePaymentResponse($response, $app, $subscriber);
          
  //     } catch (\Exception $e) {
  //         Log::error('Payment processing error: ' . $e->getMessage() .''. $paymentData);
  //         return response()->json([
  //             'status' => 500,
  //             'message' => 'An unexpected error occurred. Please try again.',
  //         ], 500);
  //     }
  // }

    private function handlePaymentResponse($response, $app, $subscriber)
      {
          if (!empty($response['link'])) {
              $app->transaction_id = $response['data']['PCODE'] ?? null;
              $app->save();

              return response()->json([
                  'status' => 200,
                  'message' => $response['data']['message'] ?? 'Payment successful.',
                  'link' => $response['link'],
              ]);
          } else {
              $app->transaction_id = $response['data']['transID'] ?? null;
              $app->request_service_paid = true;
              $app->save();

              return response()->json([
                  'status' => 200,
                  'message' => $response['data']['message'] ?? 'Payment successful.',
                  'redirect_uri' => url(route('payment.confirmation', ['plb' => $subscriber->id])),
              ]);
          }
      }


  private function sendPaymentNotifications($client, $phoneNumber)
    {
        $smsNotification = new Notifications();

        $smsData = [
            'key' => $smsNotification->getSmsApiKey(),
            'message' => 'Dear ' . $client->names . ', Your request has been successfully received by BScholarz. You\'ll be contacted for further application processes.',
            'recipients' => [$phoneNumber],
        ];

        dispatch(new SendSmsJob($smsData));
    }

  public function link_pay(Request $request)
  {
    // Validate inputs
    $validatedData = $request->validate([
      'identifier' => 'required|string|min:0',
      'amount' => 'required|numeric|min:0',
      'phone' => 'nullable|required_if:payment_method,momo|string|max:30',
      'payment_method' => 'required|string|max:10',
      'email' => 'nullable|email',
    ]);

    $phoneNumber = null;

    if ($validatedData['payment_method'] === 'momo') {
      $phoneNumber = $this->formatPhoneNumber($validatedData['phone']);

      if ($phoneNumber === null) {
        return response()->json(['message' => 'Phone number must be 10 digits long.'], 400);
      }

      if ($phoneNumber === 1) {
        return response()->json(['message' => 'Invalid phone number'], 400);
      }
    }

    $apiKey = $validatedData['payment_method'] == 'momo'
      ? $this->getApiKey($phoneNumber)
      : $this->getApiKey();

    // Prepare api data
    $data = [
      // 'amount' => intval($validatedData['amount']),
      'amount' => $validatedData['amount'],
      'phone' => $phoneNumber,
      'key' => $apiKey
    ];

    $response = $this->sendPaymentRequest($data);

    // Output the response
    // $responseData = json_decode($response, true);

    if (is_null($response)) {
      return response()->json([
        'message' => 'Operation Failed, Try again!'
      ], 500);
    }

    $status = $response['status'];

    if ($status === 200) {

      $service = Discipline::where('identifier', $validatedData['identifier'])->first();

      Session::put('service_link', $service->link);

      if (!empty($response['link'])) {

        return response()->json([
          'status' => 200,
          'message' => $response['data']['message'] ?? 'Payment successful.',
          'link' => $response['link']
        ]);
      } else {

        $amount = $response['data']['amount'];
        $uniqueId = $response['data']['transID'];

        Mail::to($validatedData['email'])->send(new AppLinkMail($service->link, $service->discipline_name));

        return response()->json([
          'status' => $status,
          'message' => 'Payment successful',
        ]);
      }
    } else {
      return response()->json([
        'status' => $status,
        'message' => $response['data']['message']
      ]);
    }
  }

  function subscriptionPayment(Request $request)
  {
    $validatedData = $request->validate([
      'subscription' => 'required',
      'amount' => 'required|numeric|min:0',
      'phone' => 'required_if:payment_method,momo|string|max:30',
      'payment_method' => 'required|string|max:255',
    ]);

    $phoneNumber = null;

    if ($validatedData['payment_method'] === 'momo') {
      $phoneNumber = $this->formatPhoneNumber($validatedData['phone']);

      if ($phoneNumber === null) {
        return response()->json(['message' => 'Phone number must be 10 digits long.'], 400);
      }

      if ($phoneNumber === 1) {
        return response()->json(['message' => 'Invalid phone number'], 400);
      }
    }

    $apiKey = $validatedData['payment_method'] == 'momo'
      ? $this->getApiKey($phoneNumber)
      : $this->getApiKey();

    $data = [
      'amount' => $validatedData['amount'],
      'phone' => $phoneNumber,
      'key' => $apiKey
    ];

    $response = $this->sendPaymentRequest($data);

    if (is_null($response)) {
      return response()->json(['message' => 'Operation Failed, Try again!'], 500);
    }

    if ($response['status'] === 200) {
      // Session::put('client', $client);
      $subscription = SubscriberSubscription::find($validatedData['subscription']);

      if (!empty($response['link'])) {
        $subscription->is_active = 1;
        $subscription->save();

        return response()->json([
          'status' => 200,
          'message' => $response['data']['message'] ?? 'Payment successful.',
          'link' => $response['link']
        ]);
      } else {

        $subscription->is_active = 1;
        $subscription->transaction_id = $response['data']['transID'];
        $subscription->save();

        return response()->json([
          'status' => 200,
          'message' => $response['data']['message'] ?? 'Payment successful.',
          'redirect_uri' => url(route('member-payment.success', ['plb' => $subscription->subscriber_id]))
        ]);
      }
    } else {
      return response()->json([
        'status' => 400,
        'message' => $response['data']['message'] ?? 'Payment Failed.'
      ]);
    }

  }

  private function sendPaymentRequest(array $data)
  {
    $encData = json_encode($data);
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $this->getApiUrl());
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $encData);
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
      curl_close($curl);
      return null;
    }

    curl_close($curl);
    return json_decode($response, true);
  }

  public function payment(Request $request)
  {
    return redirect()->route('request.payment', [
      'service' => $request->input('application_info'),
      'amount' => $request->input('amount'),
      'client' => $request->input('names')
    ]);
  }

  public function pay_view($request)
  {
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

  public function confirmation()
  {

    $client = session('client');
    $applicant = Applicant_info::where('uuid', $client)->first();

    // Display the confirmation view with session data
    return view('follow-up', compact('applicant'));
  }

  public function paymentSuccessView(Request $request)
  {
    // Display the confirmation view with session data
    return view('success');
  }

  public function confirm(Request $request)
  {

    // Retrieve the data from the session
    $link = session('service_link');

    // Display the confirmation view with session data
    return view('confirmation', compact('link'));
  }



  public function approve_payment(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'app_id' => 'required|integer|min:0',
      'identifier' => 'required|string|min:0',
      'applicant' => 'required|integer|min:0',
      'amount' => 'required|integer|min:0',
      'phone' => 'required|string|min:10|max:12',
      'payment_method' => 'required|string|max:255',
    ]);

    $client = DB::table('served_requests')->where('application_id', $request->app_id)->where('id', $request->applicant)->first();

    if ($request->payment_method == 'momo') {
      $bankid = '63510';
      $payment_number = $request->phone;
      if ($validator->fails()) {
        return back()
          ->withInput($request->input())
          ->with('phone', 'The Phone number must not be greater than 12 characters.');
      }
    } else {
      $payment_number = $request->phone;
      $bankid = '000';
    }

    $phone = $request->phone;

    if (substr(preg_replace('/[^0-9]/', '', $phone), 0, 4) == '2507' && strlen($phone) == 12) {
      $phone = $phone;
      $rightphone = true;
    } else {
      if (substr(preg_replace('/[^0-9]/', '', $phone), 0, 2) == '07' && strlen($phone) == 10) {
        $phone = '25' . $phone;
        $rightphone = true;
      } else {
        $rightphone = false;
      }
    }
    if (!$rightphone) {

      return back()
        ->withInput($request->input())
        ->with('phone', 'Invalid phone number. 07********');
    }

    function refIdGen()
    {
      return time() . '' . rand(100, 999) . '' . rand(1000, 9999);
    }

    getId:
    $refid = refIdGen();

    if (DB::table('applications')->where('payment_id', $refid)->first()) {
      goto getId;
    }

    $returl = url(route('pay-callback'));
    $redirecturl = '';

    if ($request->payment_method == 'cc') {
      $redirecturl = url(route('finish', [
        'discipline' => $request->identifier,
        'app_id' => $request->app_id,
        'applicant' => $request->applicant,
        'message' => 'Your payment was successfully received by BSholarz.',
        'subcontent' => 'Thank you for working with us.',
      ]));
    } else {
      $redirecturl = url(route('finish', [
        'discipline' => $request->identifier,
        'app_id' => $request->app_id,
        'applicant' => $request->applicant,
      ]));
    }

    $request_data = array(
      'action' => 'pay',
      'msisdn' => $phone,
      'details' => $client->discipline_name . ' Payment',
      'refid' => $refid,
      'amount' => $request->amount,
      'currency' => 'RWF',
      'email' => $client->email,
      'cname' => $client->names,
      'cnumber' => $client->phone_number,
      'pmethod' => $request->payment_method,
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

    DB::table('applications')->where('app_id', $request->app_id)->where('applicant', $request->applicant)->update(['payment_id' => $refid, 'payment_status' => 'Pending']);

    // Check for errors
    if (curl_errno($ch)) {
      // echo 'Error: ' . curl_error($ch);
      return back()
        ->withInput($request->input())
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

    if ($request->payment_method == 'cc') {
      if ($returnedData['url'] != '') {
        return redirect()->away($returnedData['url']);
      }
    } else {

      if ($returnedData['retcode'] == 01 || $returnedData['retcode'] == 0) {

        // Update applications with payment ID
        DB::table('applications')->where('app_id', $request->app_id)->where('applicant', $request->applicant)->update(['payment_id' => $refid, 'payment_status' => 'Pending']);


        if (!Auth::guard('client')->user()) {
          return redirect()->route('finish', ['discipline' => $request->identifier, 'app_id' => $request->app_id, 'applicant' => $request->applicant]);
        } else {
          return redirect()->route('client.client-dashboard');
        }

      } elseif ($returnedData['retcode'] == 03) {

        // Update applications with payment ID
        DB::table('applications')->where('app_id', $request->app_id)->where('applicant', $request->applicant)->update(['payment_id' => $refid, 'payment_status' => 'Pending']);


        if (!Auth::guard('client')->user()) {
          return redirect()->route('finish', ['discipline' => $request->identifier, 'app_id' => $request->app_id, 'applicant' => $request->applicant]);
        } else {
          return redirect()->route('client.client-dashboard');
        }

      } elseif ($returnedData['retcode'] == 606 && $returnedData['statusmsg'] == 'Not enough funds') {

        return back()
          ->withInput($request->input())
          ->with('phone', "You do not have enough funds. Consider recharging or use a different phone number.");

      } else {

        return back()
          ->withInput($request->input())
          ->with('phone', 'Something went wrong try again');

      }

    }

  }

  public function show()
  {
    return view('resp');
  }

  public function handle_callback(Request $request)
  {

    $validateData = $request->validate([
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

    return response()->json([
      'response' => $response,
    ]);


    $resp = json_decode($response, true);

    if ($resp['statusid'] == '02') {
      return redirect()->route('home');
    }


    if ($resp['statusid'] = '01') {

      // update the payment_status to 'success'
      DB::table('applications')->where('payment_id', $refId)->update(['payment_status' => 'Paid', 'payment_date' => Carbon::now()->format('Y-m-d H:i:s.u'), 'outstanding_amount' => 0]);

    } elseif ($resp['statusid'] = '02') {

      DB::table('applications')->where('payment_id', $refId)->update(['payment_status' => 'Failed']);

    } else {

      DB::table('applications')->where('payment_id', $refId)->update(['payment_status' => 'Pending']);

    }

    return response()->json([

      'message' => 'Payment callback received successfully.',

    ]);

  }

    public function Pay(Request $request) {
      // Validate the request
      $request->validate([
        'app_id' => 'required|string|min:0',
        'identifier' => 'required|string|min:0',
        'applicant' => 'required|integer|min:0',
        'amount' => 'required|numeric|min:0',
        'phone' => 'required_if:payment_method,momo|string|max:30',
        'payment_method' => 'required|string|max:10',
    ]);

      // Format the phone number
      $phone = $this->formatPhoneNumber($request->phone);

      // Get the API URL
      $url = $this->getApiUrl();

      // Get the API key based on the payment method
      $apiKey = $request->payment_method == 'momo'
          ? $this->getApiKey($phone)
          : $this->getApiKey();

      // Decrypt and validate app_id
      try {
        $app_id = Crypt::decryptString($request->input('app_id'));
        $app = Applications::findOrFail($app_id); // Throws 404 if not found
    } catch (\Exception $e) {
        return response()->json(['message' => 'Invalid application ID'], 400);
    }

      // Prepare data for the payment request
      $data = [
          'amount' => $request->amount,
          'phone' => $phone,
          'key' => $apiKey,
      ];

      // Send the payment request
      try {
          $response = $this->sendPaymentRequest($data);

          // Check if the payment was successful
          if ($response['status'] == 200) {
              // Handle different response structures based on payment method
              if ($request->payment_method == 'momo' && isset($response['data']['transID'])) {
                
                // Fetch client details
                $client = Applicant_info::where('id', $request->input('applicant'))
                ->select('uuid', 'names', 'email')
                ->first();

                Session::put('client', $client);

                $subscriber = Subscriber::where('email', $client->email)
                    ->select('id')
                    ->first();

                // Send SMS notification
                $this->sendPaymentNotifications($client->email, $phone);

                // Handle payment response and return proper response
                // return $this->handlePaymentResponse($response, $app, $subscriber);

                  // Queue an email notification
                  // if ($client->email) {
                  //   $details = [
                  //     'names' => $request->input('name') ?? 'Customer',
                  //     'subject' => 'Payment Notification',
                  //     'message' => "Your payment was successful.",
                  //   ];

                  //   Mail::to($client->email)->queue(new UserNotification($details));

                  //   $smsNotification = new Notifications();
                  //   $smsDetails = [
                  //       'key' => $smsNotification->getSmsApiKey(),
                  //       'receipients' => [$request->input('phone')],
                  //       'message' => 'Your payment was successful. Thank you for choosing Bscholarz',
                  //   ];
              
                  // dispatch(new SendSmsJob($smsDetails));
                  // }

                  return response()->json([
                      'success' => true,
                      'title' => 'Payment Successful',
                      'message' => 'Payment processed successfully.',
                      'data' => $response,
                  ]);

              } elseif ($request->payment_method == 'cc' && isset($response['PCODE'])) {
                  return response()->json([
                      'success' => true,
                      'title' => 'Redirection',
                      'message' => 'Redirecting to payment gateway...',
                      'data' => $response,
                  ]);
              } else {
                  // Handle unexpected response structure
                  return response()->json([
                      'success' => false,
                      'title' => 'Unexpected Response',
                      'message' => 'Unexpected response structure.',
                      'data' => $response,
                  ], 400);
              }
          } else {
              // Payment failed, update the payment record with the failure status
              return response()->json([
                  'success' => false,
                  'title' => 'Payment Failed',
                  'message' => 'Failed to process payment.',
                  'data' => $response,
              ], 400);
          }
      } catch (\Exception $e) {
          // Update the payment record with the error status
          return response()->json([
              'success' => false,
              'message' => 'Failed to process payment.',
              'error' => $e->getMessage(),
          ], 500);
      }
  }

    public function stdlnePayment()
    {
        return view('stdlne-pay');
    }

    public function processStdlnePayment(Request $request) {
        // Validate the request
        $request->validate([
            'phone' => 'required|string|min:10|max:15',
            'amount' => 'required|numeric|min:0',
            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'payment_method' => 'required|string|in:momo,cc', // Restrict to specific values
        ]);

        // Format the phone number
        $phone = $this->formatPhoneNumber($request->phone);

        // Get the API URL
        $url = $this->getApiUrl();

        // Get the API key based on the payment method
        $apiKey = $request->payment_method == 'momo'
            ? $this->getApiKey($phone)
            : $this->getApiKey();

        // Create a payment record
        try {
            $payment = GeneralPayments::create([
                'type' => $request->type,
                'amount' => $request->amount,
                'names' => $request->name,
                'email' => $request->email,
                'phone' => $phone,
                'description' => $request->description,
                'status' => 'pending',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create payment record.',
                'error' => $e->getMessage(),
            ], 500);
        }

        // Prepare data for the payment request
        $data = [
            'amount' => $request->amount,
            'phone' => $phone,
            'key' => $apiKey, // Use $apiKey instead of $api_key
        ];

        // Send the payment request
        try {
            $response = $this->sendPaymentRequest($data);

            // Check if the payment was successful
            if ($response['status'] == 200) {
                // Handle different response structures based on payment method
                if ($request->payment_method == 'momo' && isset($response['data']['transID'])) {
                    // Update the payment record with transaction details for MoMo
                    $payment->update([
                        'transaction_id' => $response['data']['transID'],
                        'status' => 'completed',
                    ]);

                    // Queue an email notification
                    if ($request->email) {
                      $details = [
                        'names' => $request->input('name') ?? 'Customer',
                        'subject' => 'Payment Notification',
                        'message' => $request->input('payment') ? 'Your payment was successful.' : 'Your donation was successful.',
                      ];
                      Mail::to($request->input('email'))->queue(new UserNotification($details));

                      $smsNotification = new Notifications();
                      $smsDetails = [
                          'key' => $smsNotification->getSmsApiKey(),
                          'receipients' => [$request->input('phone')],
                          'message' => $request->input('payment') ? 'Your payment was successful. Thank you for choosing Bscholarz' : 'Your donation was successful. Thank you for your support.',
                      ];
                
                    dispatch(new SendSmsJob($smsDetails));
                    }

                    return response()->json([
                        'success' => true,
                        'title' => 'Payment Successful',
                        'message' => 'Payment processed successfully.',
                        'data' => $response,
                    ]);

                } elseif ($request->payment_method == 'cc' && isset($response['PCODE'])) {
                    // For credit card payments, return the response without updating the payment record
                    $payment->update([
                        'pcode' => $response['PCODE'],
                        'status' => 'pending',
                    ]);

                    return response()->json([
                        'success' => true,
                        'title' => 'Redirection',
                        'message' => 'Redirecting to payment gateway...',
                        'data' => $response,
                    ]);
                } else {
                    // Handle unexpected response structure
                    return response()->json([
                        'success' => false,
                        'title' => 'Unexpected Response',
                        'message' => 'Unexpected response structure.',
                        'data' => $response,
                    ], 400);
                }
            } else {
                // Payment failed, update the payment record with the failure status
                $payment->update([
                    'status' => 'failed',
                ]);

                return response()->json([
                    'success' => false,
                    'title' => 'Payment Failed',
                    'message' => 'Failed to process payment.',
                    'data' => $response,
                ], 400);
            }
        } catch (\Exception $e) {
            // Update the payment record with the error status
            $payment->update([
                'status' => 'failed',
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to process payment.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getPayments($type) {
        try {
            // Validate that 'type' exists in allowed values (optional, based on your use case)
            $validTypes = ['payment', 'donation'];
            if (!in_array($type, $validTypes)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid payment type.',
                ], 400); // Bad Request
            }

            // Fetch payments based on the type
            $payments = GeneralPayments::where('type', $type)->whereNotNull('transaction_id')->get();

            // If no payments found, return a 404 response
            if ($payments->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No payments found for the given type.',
                    'data' => [],
                ], 404);
            }

            // Return successful response
            return response()->json([
                'success' => true,
                'data' => $payments,
            ], 200);

        } catch (\Exception $e) {
            // Catch any unexpected errors and return a server error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching payments.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
