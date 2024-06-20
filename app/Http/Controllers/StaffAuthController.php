<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use DB;
 
class StaffAuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     */

     public function signin() {
    
        if (!Auth::guard('staff') -> user()) {
            return view('auth.staff-login');
        }

        else {
            return redirect() -> route('staff-dashboard');
        }

     }

    public function authenticate_staff(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $staffInfo = $request -> all();
 
        if (Auth::guard('staff') -> attempt(['email' => $staffInfo['email'], 'password' => $staffInfo['password']])) {
            $request->session()->regenerate();

            if (Auth::guard('staff') -> user() -> working_status == 'Fired') {

                Auth::guard('staff')->logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();
                    
                return redirect() -> route('fired-staff-notify');
            }

            else {

                DB::table('staff') -> limit(1) -> where('id', Auth::guard('staff') -> user() -> id) -> update(['status' => 'Online']);
 
                return redirect() -> route('staff-dashboard');
    
            }

        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    
}