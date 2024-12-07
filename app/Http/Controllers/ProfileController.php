<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffProfileUpdateRequest;
use App\Http\Requests\DevProfileUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Staff;
use App\Models\RhythmBox;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\View\View;
use DB;
use File;

class ProfileController extends Controller {
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View {
        if(Auth::guard('staff')) {
            $history = DB::table('staff_activities')->where('staff', Auth::guard('staff')->user()->id)->get();
        }

        return view('profile.edit', [
            'user' => $request->user(),
            'history' => $history,
        ]);
    }

    public function edit_profile(Request $request): View
    {

        $user = DB::table('rhythmbox') -> where('id', Auth::guard('rhythmbox') -> user() -> id) -> first();

        return view('profile.rhythmbox-profile', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        $request -> user() -> phone_number = $request -> phone;
        $request->user()->save();

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function update_rhythmbox_profile(DevProfileUpdateRequest $request)
    {

        $user = RhythmBox::find($request -> id);

        if ($user -> isDirty('email')) {
            $user -> email_verified_at = null;
        }

        $data = $request->validated();
        
        $user -> fill($data);

        $user -> update($data);

        return back();
    }


    public function partner_update_profile_pic(Request $request)
    {

        if($request -> hasFile('profile_image')) {

            $profile_image = time().'-'.$request -> file('profile_image') -> getClientOriginalName();

            if (File::exists(public_path('profile_pictures/'.Auth::guard('rhythmbox') -> user() -> profile_picture))) {
                File::delete(public_path('profile_pictures/'.Auth::guard('rhythmbox') -> user() -> profile_picture));
            }
            
            DB::table('rhythmbox') -> limit(1) -> where('id', Auth::guard('rhythmbox') -> user() -> id) -> update(['profile_picture' => $profile_image ]);
            $request -> file('profile_image') -> move(public_path('profile_pictures/'), $profile_image);
        }

        return back();
    }


    public function update_staff_profile(StaffProfileUpdateRequest $request) {
        $user = Staff::findOrFail($request->staff_id);
        $user -> update($request->validated());
        return back()->with('updated', 'Profile updated successfully');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
