<?php

namespace App\Http\Controllers\Auth;

use DB;
use App\Models\RhythmBox;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    public function change_dev_password(Request $request) : RedirectResponse {

        $request -> validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed']
        ]);
        
        $user = RhythmBox::find($request -> id);

        if (Hash::check($request -> current_password, $user -> password)) {
            
            $user -> update([
                'password' => Hash::make($request -> password)
            ]);

            return back() -> with('status', 'password changed!');
        }

        else {
            return back() -> with('status', 'Failed to change password!');
        }

    }

    public function change_staff_password(Request $request) : RedirectResponse {

        $request -> validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed']
        ]);
        
        $user = Staff::find($request -> user_id);

        if (Hash::check($request -> current_password, $user -> password)) {
            
            $user -> update([
                'password' => Hash::make($request -> password)
            ]);

            return back() -> with('status', 'password changed!');
        }

        else {
            return back() -> with('status', 'Failed to change password!');
        }

    }

    public function update_rhythmbox(Request $request): RedirectResponse
    {
        $validated = $request -> validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed'],
        ]);

        if(Auth::guard('rhythmbox') -> attempt(['password' => $validated['current_password']])){
            DB::table('rhythmbox') -> limit(1) -> where('id', Auth::guard('rhythmbox') -> user() -> id) ->update([
                'password' => Hash::make($validated['password'])
            ]);
            
            return back() -> with('status', 'password-updated');
        }

        else {
            return back() -> with("error", "Old Password Doesn't match!");
        }
    }
}
