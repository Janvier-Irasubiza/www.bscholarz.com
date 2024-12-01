<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Utils extends Controller
{
    public function formatPhoneNumber($phoneNumber)
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
}
