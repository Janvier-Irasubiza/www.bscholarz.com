<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Model\Applicant_info;
use App\Mail\ForgotAccountPassword;
use DB;
use Hash;
use Mail;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }
  
  	public function clients_fp_view(): View
    {
        return view('auth.clients-forgot-password');
    }
  
  	public function staff_fp_view(): View
    {
        return view('auth.staff-forgot-password');
    }
  
  	public function partners_fp_view(): View
    {
        return view('auth.partners-forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
      
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }
  
  	
  	
  	public function send_client_password_reset_link(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);
      
      	$sendto = $request -> email;
      
      	$client = DB::table('applicant_info') -> where('email', $request -> email) -> first();
      
      	if(!empty($client)) {
        
        $token = Str::random(64);

        if(DB::table('password_reset_tokens') -> where('email', $request -> email) -> exists()) {
        
          $status = 'Please wait before retrying.';
          
        	return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
        }
          
          else {
          
            DB::table('password_reset_tokens')->insert([
            'email' => $request->email, 
            'token' => Hash::make($token), 
            'created_at' => Carbon::now()
        	]);
            
            $url = url(route('client-password.reset', [
                'token' => $token,
                'email' => $request -> email,
            ], false));
                        
            if(Mail::to($request->email) -> send(new ForgotAccountPassword($url, $client -> names), ['token' => $token])) 
          
                $status = 'Check your email, we have emailed you a password reset link.';

                  return $status == Password::RESET_LINK_SENT
                          ? back()->with('status', __($status))
                          : back()->withInput($request->only('email'))
                                  ->withErrors(['success' => __($status)]);

              }
          }
      
      		else {

               $status = 'Found no records associated with this email.';

                  return $status == Password::RESET_LINK_SENT
                          ? back()->with('status', __($status))
                          : back()->withInput($request->only('email'))
                                  ->withErrors(['email' => __($status)]);

            }
    }
  
  	public function send_staff_password_reset_link(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);
      
      	$sendto = $request -> email;
      
      	$emp = DB::table('staff') -> where('email', $request -> email) -> first();
      
      	if(!empty($emp)) {
        
        $token = Str::random(64);

        if(DB::table('password_reset_tokens') -> where('email', $request -> email) -> exists()) {
        
          $status = 'Please wait before retrying.';
          
        	return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
        }
          
          else {
          
            DB::table('password_reset_tokens')->insert([
            'email' => $request->email, 
            'token' => Hash::make($token), 
            'created_at' => Carbon::now()
        	]);
            
            $url = url(route('staff-password.reset', [
                'token' => $token,
                'email' => $request -> email,
            ], false));
                        
            if(Mail::to($request->email) -> send(new ForgotAccountPassword($url, $emp -> names), ['token' => $token])) 
          
                $status = 'Check your email, we have emailed you a password reset link.';

                  return $status == Password::RESET_LINK_SENT
                          ? back()->with('status', __($status))
                          : back()->withInput($request->only('email'))
                                  ->withErrors(['success' => __($status)]);

              }
          }
      
      		else {

               $status = 'Found no records associated with this email.';

                  return $status == Password::RESET_LINK_SENT
                          ? back()->with('status', __($status))
                          : back()->withInput($request->only('email'))
                                  ->withErrors(['email' => __($status)]);

            }
    }
  
  public function send_partner_password_reset_link(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);
      
      	$sendto = $request -> email;
      
      	$partner = DB::table('rhythmbox') -> where('email', $request -> email) -> first();
      
      	if(!empty($partner)) {
        
        $token = Str::random(64);

        if(DB::table('password_reset_tokens') -> where('email', $request -> email) -> exists()) {
        
          $status = 'Please wait before retrying.';
          
        	return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
        }
          
          else {
          
            DB::table('password_reset_tokens')->insert([
            'email' => $request->email, 
            'token' => Hash::make($token), 
            'created_at' => Carbon::now()
        	]);
            
            $url = url(route('partner-password.reset', [
                'token' => $token,
                'email' => $request -> email,
            ], false));
                        
            if(Mail::to($request->email) -> send(new ForgotAccountPassword($url, $partner -> names), ['token' => $token])) 
          
                $status = 'Check your email, we have emailed you a password reset link.';

                  return $status == Password::RESET_LINK_SENT
                          ? back()->with('status', __($status))
                          : back()->withInput($request->only('email'))
                                  ->withErrors(['success' => __($status)]);

              }
          }
      
      		else {

               $status = 'Found no records associated with this email.';

                  return $status == Password::RESET_LINK_SENT
                          ? back()->with('status', __($status))
                          : back()->withInput($request->only('email'))
                                  ->withErrors(['email' => __($status)]);

            }
    }
  
} 
