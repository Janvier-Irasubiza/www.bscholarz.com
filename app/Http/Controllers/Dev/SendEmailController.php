<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactDevMail;

class SendEmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'request' => 'required|string',
        ]);

        try {
            Mail::to('arhythmbox@gmail.com')->send(new ContactDevMail($request->all()));
            return response()->json(['message' => 'Email sent successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send email.'], 500);
        }
    }
}
