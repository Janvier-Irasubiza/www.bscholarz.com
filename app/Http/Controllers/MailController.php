<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Post;
use Mail;

class MailController extends Controller
{
    public function send_mail($receipients, $url, $title, $type, $desc) {
      foreach($receipients as $receipient) {

        if (isset($receipient['email'])) {
          Mail::to($receipient['email']) -> send(new Post($url, $title, $type, $desc));
        }
        
      }

      return response()->json(['status', 'sent']);
    }
}
