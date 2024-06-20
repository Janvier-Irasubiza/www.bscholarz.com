<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class Callbacks extends Controller {
  
  	public function payment_callback(Request $request) {
      
        $responseString = $request->getContent(); // Get the raw response string
      
      	// Log::channel('daily')->info('API Response: ' . json_encode($responseString));
      
         // Decode the JSON string into an associative array

        if ($request->getContent()) {
          
            $responseData = json_decode($responseString, true);
          
            // Access the individual fields from the response data
            $transactionId = $responseData['tid'];
            $refId = $responseData['refid'];
            $statusDesc = $responseData['statusdesc'];
            $statusid = $responseData['statusid'];
          
          	date_default_timezone_set('Africa/Kigali');
          
            if ($statusid == '01') {
              
                // update the payment_status to 'success'
                DB::table('applications') -> where('payment_id', $refId) -> update(['payment_status' => 'Paid', 'payment_date' => Carbon::now()->format('Y-m-d H:i:s.u'), 'outstanding_amount' => 0]);
            
            }
          
            elseif ($statusid == '02') {
              
                DB::table('applications') -> where('payment_id', $refId) -> update(['payment_status' => 'Failed']);
            
            }
          
            else{
              
                DB::table('applications') -> where('payment_id', $refId) -> update(['payment_status' => 'Pending']);
            
            }

            return response()->json([
              
                'message' => 'Payment callback received successfully.',
              
            ]);
          
        } 
      
      else {
          
            // Handle the case when the response data is not valid JSON
            return response()->json([
                'error' => 'Invalid response data.',
            ], 400);
          
        }
            
    }
  
    public function sms_callback(Request $request) {
      
      $responseString = $request->getContent();

      return $responseString;

    }
  
}