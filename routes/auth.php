<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\StaffAuthController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientAuthController;
use App\Http\Controllers\RhythmBox\RhythmBoxController;

Route::middleware('guest')->group(function () {
    Route::get('register', [ClientAuthController::class, 'register_client']) ->name('register');

    Route::post('register', [ClientAuthController::class, 'store_client_data']);

    Route::post('auth', [ClientAuthController::class, 'clientAuth']) -> name('client.auth');
  
  	Route::post('/set-client-password/{client}', [ClientAuthController::class, 'set_client_password']) -> name('set-client-password');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::get('authenticate', [StaffAuthController::class, 'signin'])
                ->name('authenticate');

    Route::post('staff-login', [StaffAuthController::class, 'authenticate_staff'])
                ->name('staff-login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('rhythmbox/auth', [RhythmBoxController::class, 'login']) -> name('rhythmbox.login');   
    Route::post('rhythmbox/login', [RhythmBoxController::class, 'auth']) -> name('rhythmbox.auth');  

    Route::get('rhythmbox/register', [RhythmBoxController::class, 'register']) -> name('rhythmbox.register');   
    Route::post('rhythmbox/create', [RhythmBoxController::class, 'create']) -> name('rhythmbox.create');   

    Route::get('forgot-password', [PasswordResetLinkController::class, 'clients_fp_view'])
                ->name('clients-password.request');
  
  	Route::get('admin-forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');
  
  	Route::get('staff-forgot-password', [PasswordResetLinkController::class, 'staff_fp_view'])
                ->name('staff-password.request');
  
  	Route::get('partner-forgot-password', [PasswordResetLinkController::class, 'partners_fp_view'])
                ->name('partner-password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');
  
  	Route::post('forgot-account-password', [PasswordResetLinkController::class, 'send_client_password_reset_link'])
                ->name('client-password.email');
  
  	Route::post('forgot-my-password', [PasswordResetLinkController::class, 'send_staff_password_reset_link'])
                ->name('staff-password.email');
  
  	Route::post('get-reset-link', [PasswordResetLinkController::class, 'send_partner_password_reset_link'])
                ->name('partner-password.email');
  
  	Route::get('admin-reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');
  
  	Route::get('reset-password/{token}', [NewPasswordController::class, 'client_reset_password_view'])
                ->name('client-password.reset');
  
  	Route::get('reset-my-password/{token}', [NewPasswordController::class, 'staff_reset_password_view'])
                ->name('staff-password.reset');
  
  	Route::get('partner-reset-password/{token}', [NewPasswordController::class, 'partner_reset_password_view'])
                ->name('partner-password.reset');

    Route::post('admin-reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
  
  	Route::post('reset-password', [NewPasswordController::class, 'client_reset_password'])
                ->name('client-password.store');
  
    Route::post('staff-reset-password', [NewPasswordController::class, 'staff_reset_password'])
                ->name('staff-password.store');
  
  	Route::post('reset-my-password', [NewPasswordController::class, 'reset_partner_password'])
                ->name('partner-password.store');

    
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');

});
