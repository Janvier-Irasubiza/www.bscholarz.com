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

    public function signin()
    {

        if (!Auth::guard('staff')->user()) {
            return view('auth.staff-login');
        } else {
            return redirect()->route('staff-dashboard');
        }

    }

    public function authenticate_staff(Request $request): RedirectResponse
    {
        // Validate credentials
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('staff')->attempt($credentials)) {
            $request->session()->regenerate(); // Regenerate session for security

            $user = Auth::guard('staff')->user(); // Get authenticated staff user
            $department = strtolower($user->department->name); // Normalize department names
            $workingStatus = strtolower($user->working_status); // Normalize working status

            if ($user->type == 'admin') {
                return redirect()->route('admin.dashboard'); // Admin dashboard
            }

            if ($workingStatus === 'fired') {
                Auth::guard('staff')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('fired-staff-notify'); // Notify fired staff
            }

            // Update staff status to 'Online'
            DB::table('staff')->where('id', $user->id)->update(['status' => 'Online']);

            // Redirect based on department
            switch ($department) {
                case 'marketing':
                    return redirect()->route('md.dashboard'); // Marketing dashboard

                case 'accountability':
                case 'accounting':
                    return redirect()->route('accountant-dashboard'); // Accountant dashboard

                case 'development':
                    return redirect()->route('dev.index'); // Development dashboard

                default:
                    return redirect()->route('staff-dashboard'); // Default staff dashboard
            }
        }

        // Return error if authentication fails
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
