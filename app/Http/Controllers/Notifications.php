<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Notifications extends Controller
{

    private function getSmsApiUrl()
    {
        return env('SMS_API_URL');
    }

    public function getSmsApiKey()
    {
        return env('SMS_API_KEY');
    }

    public function testSms(Request $request){
        $data = [
            'key' => env('SMS_API_KEY'),
            'message' => "Hello, this is a test message",
            'recipients'=> [
                '0781336634',
                '0781336634'
            ],
        ];  

        // return response()->json($data);

        $response = $this->sendSms($data);
        return response()->json($response);
    }

    public function sendSms($data)
    {

        $encData = json_encode($data);
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->getSmsApiUrl());
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
}
