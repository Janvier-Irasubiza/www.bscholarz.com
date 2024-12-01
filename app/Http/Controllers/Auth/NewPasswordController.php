<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Applicant_info;
use App\Models\Subscriber;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use DB;

class NewPasswordController extends Controller
{
  /**
   * Display the password reset view.
   */
  public function create(Request $request): View
  {
    $user = DB::table('password_reset_tokens')->where('email', $request->email)->first();

    if ($user && Hash::check($request->token, $user->token)) {
      return view('auth.reset-password', ['request' => $request]);
    } else {
      return view('auth.reset-password', ['request' => $request, 'error' => 'Your reset link has been expired']);
    }
  }

  public function set_password(Request $request): View
  {
    $user = Subscriber::find($request->plb);
    return view('auth.set-password', compact('user'));
  }

  public function set_new_password(Request $request)
  {
    $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ], [
      'email.required' => 'The email field is required.',
      'password.confirmed' => 'The passwords do not match.',
    ]);

    $user = Applicant_info::where('email', $request->email)->first();
    if (!$user) {
      return back()->withInput($request->only('email'))
        ->withErrors(['email' => 'User Account not found']);
    }

    $user->password = Hash::make($request->password);
    $user->save();

    auth()->guard('client')->login($user);
    return redirect()->route('client.client-dashboard');
  }

  public function client_reset_password_view(Request $request): View
  {

    $user = DB::table('password_reset_tokens')->where('email', $request->email)->first();

    if ($user && Hash::check($request->token, $user->token)) {
      return view('auth.client-reset-password', ['request' => $request]);
    } else {
      return view('auth.client-reset-password', ['request' => $request, 'error' => 'Your reset link has been expired']);
    }

  }

  public function partner_reset_password_view(Request $request): View
  {

    $user = DB::table('password_reset_tokens')->where('email', $request->email)->first();

    if ($user && Hash::check($request->token, $user->token)) {
      return view('auth.partner-reset-password', ['request' => $request]);
    } else {
      return view('auth.partner-reset-password', ['request' => $request, 'error' => 'Your reset link has been expired']);
    }

  }

  public function staff_reset_password_view(Request $request): View
  {

    $user = DB::table('password_reset_tokens')->where('email', $request->email)->first();

    if ($user && Hash::check($request->token, $user->token)) {
      return view('auth.staff-reset-password', ['request' => $request]);
    } else {
      return view('auth.staff-reset-password', ['request' => $request, 'error' => 'Your reset link has been expired']);
    }

  }

  /**
   * Handle an incoming new password request.
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function store(Request $request): RedirectResponse
  {
    $request->validate([
      'token' => ['required'],
      'email' => ['required', 'email'],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    // Here we will attempt to reset the user's password. If it is successful we
    // will update the password on an actual user model and persist it to the
    // database. Otherwise we will parse the error and return the response.
    $status = Password::reset(
      $request->only('email', 'password', 'password_confirmation', 'token'),
      function ($user) use ($request) {
        $user->forceFill([
          'password' => Hash::make($request->password),
          'remember_token' => Str::random(60),
        ])->save();

        event(new PasswordReset($user));
      }
    );

    // If the password was successfully reset, we will redirect the user back to
    // the application's home authenticated view. If there is an error we can
    // redirect them back to where they came from with their error message.
    return $status == Password::PASSWORD_RESET
      ? redirect()->route('login')->with('status', __($status))
      : back()->withInput($request->only('email'))
        ->withErrors(['email' => __($status)]);
  }

  public function client_reset_password(Request $request): RedirectResponse
  {

    $request->validate([
      'token' => ['required'],
      'email' => ['required', 'email'],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $user = DB::table('password_reset_tokens')->where('email', $request->email)->first();

    if (!empty($user)) {

      if (Hash::check($request->token, $user->token)) {

        if (DB::table('applicant_info')->where('email', $request->email)->exists()) {

          DB::table('applicant_info')->limit(1)->where('email', $request->email)->update(['password' => Hash::make($request->input('password'))]);

          $status = "Successfully reseted your password";

          return redirect()->route('login')->withErrors(['pass_changed' => __($status)]);

        } else {

          $status = "Found no record associated with this email.";

          return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
              ->withErrors(['no_user' => __($status)]);

        }

      } else {

        $status = "Your password reset token is invalid, request another reset link.";

        return $status == Password::RESET_LINK_SENT
          ? back()->with('status', __($status))
          : back()->withInput($request->only('email'))
            ->withErrors(['inv_token' => __($status)]);

      }

    } else {

      $status = "Can't reset your password. You password reset link might have been expired, request another to be able to reset your password.";

      return $status == Password::RESET_LINK_SENT
        ? back()->with('status', __($status))
        : back()->withInput($request->only('email'))
          ->withErrors(['failed' => __($status)]);

    }

  }

  public function staff_reset_password(Request $request): RedirectResponse
  {

    $request->validate([
      'token' => ['required'],
      'email' => ['required', 'email'],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $user = DB::table('password_reset_tokens')->where('email', $request->email)->first();

    if (!empty($user)) {

      if (Hash::check($request->token, $user->token)) {

        if (DB::table('staff')->where('email', $request->email)->exists()) {

          DB::table('staff')->limit(1)->where('email', $request->email)->update(['password' => Hash::make($request->input('password'))]);

          $status = "Successfully reseted your password";

          return redirect()->route('authenticate')->withErrors(['pass_changed' => __($status)]);

        } else {

          $status = "Found no record associated with this email.";

          return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
              ->withErrors(['no_user' => __($status)]);

        }

      } else {

        $status = "Your password reset token is invalid, request another reset link.";

        return $status == Password::RESET_LINK_SENT
          ? back()->with('status', __($status))
          : back()->withInput($request->only('email'))
            ->withErrors(['inv_token' => __($status)]);

      }

    } else {

      $status = "Can't reset your password. You password reset link might have been expired, request another to be able to reset your password.";

      return $status == Password::RESET_LINK_SENT
        ? back()->with('status', __($status))
        : back()->withInput($request->only('email'))
          ->withErrors(['failed' => __($status)]);

    }

  }

  public function reset_partner_password(Request $request): RedirectResponse
  {

    $request->validate([
      'token' => ['required'],
      'email' => ['required', 'email'],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $user = DB::table('password_reset_tokens')->where('email', $request->email)->first();

    if (!empty($user)) {

      if (Hash::check($request->token, $user->token)) {

        if (DB::table('rhythmbox')->where('email', $request->email)->exists()) {

          DB::table('rhythmbox')->limit(1)->where('email', $request->email)->update(['password' => Hash::make($request->input('password'))]);

          $status = "Successfully reseted your password";

          return redirect()->route('rba')->withErrors(['pass_changed' => __($status)]);

        } else {

          $status = "Found no record associated with this email.";

          return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
              ->withErrors(['no_user' => __($status)]);

        }

      } else {

        $status = "Your password reset token is invalid, request another reset link.";

        return $status == Password::RESET_LINK_SENT
          ? back()->with('status', __($status))
          : back()->withInput($request->only('email'))
            ->withErrors(['inv_token' => __($status)]);

      }

    } else {

      $status = "Can't reset your password. You password reset link might have been expired, request another to be able to reset your password.";

      return $status == Password::RESET_LINK_SENT
        ? back()->with('status', __($status))
        : back()->withInput($request->only('email'))
          ->withErrors(['failed' => __($status)]);

    }

  }

}
