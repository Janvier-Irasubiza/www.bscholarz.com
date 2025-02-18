<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Exception;

class SmsService
{
    /**
     * Send an SMS using the configured API.
     *
     * @param array $data
     * @return array|null
     */
    public function sendSms(array $data)
    {
        try {
            $encData = json_encode($data);
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $this->getSmsApiUrl());
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $encData);
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

            $response = curl_exec($curl);

            if (curl_errno($curl)) {
                Log::error('SMS API Error: ' . curl_error($curl));
                curl_close($curl);
                return null;
            }

            curl_close($curl);
            $decodedResponse = json_decode($response, true);

            Log::info('SMS Sent: ' . json_encode($decodedResponse));

            return $decodedResponse;
        } catch (Exception $e) {
            Log::error('SMS Sending Failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get the SMS API URL.
     * Modify this to return the correct API URL.
     */
    private function getSmsApiUrl()
    {
        return env('SMS_API_URL', 'https://itecsms.rw/api/sendsms');
    }
}
