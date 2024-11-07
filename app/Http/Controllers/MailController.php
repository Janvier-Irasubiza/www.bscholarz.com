<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Post;
use Mail;
use DB;

class MailController extends Controller
{
    public function new_app_mail(Request $request) {

      $receipients = [];
          
      $users = DB::table('applicant_info') -> get();
      $subs = DB::table('subscribers') -> get();

      foreach($users as $user) {
        array_push($receipients, [
          'email' => $user -> email, 
        ]);
      }
      
      foreach($subs as $sub) {
        array_push($receipients, [
          'email' => $sub -> email, 
        ]);
      }

      foreach($receipients as $receipient) {

        if (isset($receipient['email'])) {
          try {
            Mail::to($receipient['email']) 
            ->send(new Post(
              $request->url, 
              $request->title, 
              $request->type, 
              $request->desc
            ));

            return response()->json([
              'status' => 'success',
              'message' => 'Mails sent successfully'
            ], 200);
          }
          catch (\Exception $e) {
            return response()->json([
              'status'=>'error',
              'message'=>'Mail not sent',
              'error'=>$e->getMessage()
            ], 500);
          }
        }
        
      }
    }
}
