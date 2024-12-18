<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use DB;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
     public function create(Request $request)
    {
        
        if(!Auth::guard('client') -> user()) {
          
          	if($request -> email){
              $user = DB::table('applicant_info') -> where('email', $request -> email) -> first();
              if($user -> password == '') {
                return view('auth.login', ['email' => $request -> email, 'set_key' => 'ok', 'discipline_id' => $request -> discipline_id, 'discipline_identifier' => $request -> discipline_identifier]);
              }
              
              else {
                return view('auth.login', ['email' => $request -> email, 'discipline_id' => $request -> discipline_id, 'discipline_identifier' => $request -> discipline_identifier]);
              }
            }
          
          if($request -> user_email){
              $user = DB::table('applicant_info') -> where('email', $request -> user_email) -> first();
              if($user -> password == '') {
                return view('auth.login', ['user_email' => $request -> user_email, 'set_key' => 'ok']);
              }
              
              else {
                return view('auth.login', ['user_email' => $request -> user_email]);
              }
            }

            else {
                return view('auth.login');
              }

            
        }

        else {
            return redirect() -> route('client.client-dashboard');
        }

    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect() -> route('admin.auth');
    }

    public function rhythmbox_destroy(Request $request): RedirectResponse
    {

        DB::table('rhythmbox') -> where('id', Auth::guard('rhythmbox') -> user() -> id) -> limit(1) -> update(['active_status' => 'Offline']);

        Auth::guard('rhythmbox')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect() -> route('rhythmbox.login');
    }

    public function staff_destroy(Request $request): RedirectResponse
    {

        // DB::table('staff') -> limit(1) -> where('id', Auth::guard('staff') -> user() -> id) -> update(['status' => 'Offline']);

        Auth::guard('staff')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect() -> route('authenticate');
    }

    public function client_destroy(Request $request): RedirectResponse
    {
        Auth::guard('client')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect() -> route('home');
    }
    
}
