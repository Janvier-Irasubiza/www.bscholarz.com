<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\RedirectResponse;
use App\Models\Applicant_info;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Mail\Welcome;
use DB;
use Session;
use Mail;
 
class ClientAuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     */

     public function register_client()
    {
        return view('auth.register');
    }

     public function store_client_data (Request $request): RedirectResponse {


        $messages = [
            'g-recaptcha-response.required' => 'Please complete the CAPTCHA to proceed.',
            'g-recaptcha-response.captcha' => 'The CAPTCHA verification failed, please try again.',
        ];

        $request -> validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'g-recaptcha-response' => 'required|captcha',
        ], $messages);
       
       $client = DB::table('applicant_info') -> where('email', $request -> email) -> first();

       if($client) {

         DB::table('applicant_info') -> where('email', $request -> email) -> update(['password' => Hash::make($request->password)]);

       }
       else {

        $applicant_info = Applicant_info::create([
            'names' => $request -> name,
            'email' => $request -> email,
            'password' => Hash::make($request->password),
        ]);
         
         event(new Registered($applicant_info));
       }
       
        

        $clientInfo = $request -> all();
       
       	$url = url(route('client.client-dashboard'));
		$client = $request -> name;

		Mail::to($request -> email) -> send(new Welcome($url, $client));
       
 
        if (Auth::guard('client') -> attempt(['email' => $clientInfo['email'], 'password' => $clientInfo['password']])) {
            $request->session()->regenerate();
 
            return redirect() -> route('client.client-dashboard');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
     }
  
  	public function set_client_password(Request $request){
  	
  	 $request -> validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
      
      $clientId = Crypt::decrypt($request -> client);
      
      if(DB::table('applicant_info') -> where('id', $clientId) -> first()) {
      
        DB::table('applicant_info') -> limit(1) -> where('id', $clientId) -> update(['password' => Hash::make($request -> input('password'))]);
        
        return redirect() -> route('login');
        
      }
      
      else {
      
        return redirect() -> route('home');
        
      }
      
    }


     public function staff_create_client (Request $request) {
        $request -> validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:'.Applicant_info::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
 
            $new_client_info = Applicant_info::create([
                'names' => $request -> name,
                'email' => $request -> email,
                'password' => Hash::make($request->password),
                'created_by' => Auth::guard('staff') -> user() -> names,
            ]);

            Session::put('success_msg', 'Client Created Successfully!');

            return redirect() -> back();

     }


     public function clientAuth (Request $request): RedirectResponse {

        if($request -> has('set_key')) {

            $request -> validate([
                'email' => ['required'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $clientInfo = $request -> all();

            if(DB::table('applicant_info') -> where('email', $clientInfo['email']) -> limit(1) -> update(['password' => Hash::make($clientInfo['password'])])) {
                if (Auth::guard('client') -> attempt(['email' => $clientInfo['email'], 'password' => $clientInfo['password']])) {

                    $request->session()->regenerate();
    
                    if($request -> has('discipline_id') && $request -> has('discipline_identifier'))
    
                        return redirect() -> route('client-apply', ['discipline_id' => $request -> discipline_identifier]);
        
                    return redirect() -> route('client.client-dashboard');
                }
            }


            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');

            

        }

        else {
            $request -> validate([
                'email' => ['required'],
                'password' => ['required'],
            ]); 

            $clientInfo = $request -> all();
 
        if (Auth::guard('client') -> attempt(['email' => $clientInfo['email'], 'password' => $clientInfo['password']])) {

            $request->session()->regenerate();

            if($request -> has('discipline_id') && $request -> has('discipline_identifier'))

                return redirect() -> route('client-apply', ['discipline_id' => $request -> discipline_identifier]);
 
            return redirect() -> route('client.client-dashboard');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');

        }
     }

     public function logout(Request $request): RedirectResponse {
        Auth::guard('client')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}