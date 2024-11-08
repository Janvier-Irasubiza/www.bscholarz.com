<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\Callbacks;
use App\Http\Controllers\ClientApplicationsController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\UserRequestController;
use App\Http\Controllers\ClientRequestController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\RhythmBox\RhythmBoxController;
use App\Http\Controllers\Admin\ApplicationsController;
use App\Http\Controllers\Accountability\AccountabilityController;
use App\Http\Controllers\Accountability\ExportsController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\ClientAuthController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\MdController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ChatsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PagesController::class, 'Index']) -> name('home');
Route::get('/be-a-scholar', [PagesController::class, 'BeScholar']) -> name('BeScholar');
Route::get('/get-employed', [PagesController::class, 'get_employed']) -> name('get-employed');
Route::get('/about-us', [PagesController::class, 'about_us']) -> name('about-us');
Route::get('/contact-us', [PagesController::class, 'contact_us']) -> name('contact-us');
Route::get('/felowships-trainings', [PagesController::class, 'felowships_trainings']) -> name('felowships-trainings');
Route::get('/learnMore/{discipline_id}', [PagesController::class, 'discipline_learn_more']) -> name('learnMore');
Route::get('/visit-official-web/{discipline_id}', [PagesController::class, 'visit_official_web']) -> name('visit-official-web');
Route::get('/apply/{discipline_id}', [UserRequestController::class, 'apply']) -> name('apply');
// Route::get('/req/{discipline_id}', [UserRequestController::class, 'apply']) -> name('apply');
/* Route::get('/apply/{discipline_id}', function(){
  return redirect() -> route('notice');
}) -> name('apply'); */

Route::get('/ksp-apply', function() {
    return redirect()->away('https://ksp.bscholarz.com/apply');
}) -> name('ksp-apply');

Route::get('/apply/{discipline}/payment', [PaymentsController::class, 'payment_view']) -> middleware('guest') -> name('app-payment');
Route::post('/apply/payment/approve', [PaymentsController::class, 'approve_payment']) -> name('client.payment');
Route::post('/user-request', [UserRequestController::class, 'user_request_application']) -> name('user-request-application');
Route::get('/apply/{discipline}/approve', [PagesController::class, 'follow_up_options']) -> name('follow-up');
Route::get('/apply/{discipline}/approve', [PagesController::class, 'follow_up_options']) -> name('follow-up');
Route::get('/apply/{discipline}/complete', [PagesController::class, 'finish']) -> name('finish');
Route::get('/Client-dashboard', [PagesController::class, 'client_dashboard']) -> name('Client-dashboard');
Route::get('app-apply/{request_id}', [ClientApplicationsController::class, 'app_apply']) -> name('app-apply');
Route::get('/postpone/{request_id}', [ClientApplicationsController::class, 'PostponeApp']) -> name('postpone');
Route::get('/complete/{request_id}', [ClientApplicationsController::class, 'CompleteApp']) -> name('complete');
Route::get('/search', [PagesController::class, 'search']) -> name('search');
Route::post('/seek-assistance', [PagesController::class, 'seek_assistance']) -> name('seek-assistance');
Route::post('/subscribe', [PagesController::class, 'subscribe']) -> name('subscribe');
Route::get('/payment/callback/view', [PaymentsController::class, 'show']) -> name('res.show');
Route::get('/faq', [PagesController::class, 'faq']) -> name('faq');
Route::post('/payment', [PaymentsController::class, 'handle_callback']) -> name('pay-callback');
Route::get('/sms/callback', [Callbacks::class, 'sms_callback']) -> name('sms-callback');
Route::get('/visit-official-institution', function(Request $request) {
  return redirect() -> away($request -> website_link);
}) -> name('visit-official-institution');

Route::prefix('client') -> middleware(['client']) -> group(function() {
    Route::get('/dashboard', [PagesController::class, 'client_dashboard']) -> name('client.client-dashboard');
    Route::get('/client-apply/{discipline_id}', [PagesController::class, 'client_apply']) -> name('client-apply');
    Route::post('/client-request', [ClientRequestController::class, 'client_application']) -> name('client-appication');
    Route::get('/client-learnmore/{discipline_id}', [PagesController::class, 'client_item_learn_more']) -> name('item-learnmore');
    Route::get('/client-profile', [PagesController::class, 'client_profile']) -> name('client-profile');
    Route::get('/delete-doc/{document_id}', [PagesController::class, 'delete_document']) -> name('delete-doc');
    Route::post('/client-profile-update', [PagesController::class, 'profile_update']) -> name('client-profile-update');
    Route::get('/delete-background/{back_id}', [PagesController::class, 'delete_background']) -> name('delete-background');
});


Route::get('client-logout', [AuthenticatedSessionController::class, 'client_destroy']) -> name('client.logout');

Route::get('/admin', function () {
    return redirect() -> route('admin.dashboard');
});

Route::prefix('admin') -> group(function () {
    Route::get('/auth', [AdminController::class, 'login']) -> name('admin.auth');
    Route::get('/dashboard', [AdminController::class, 'dashboard']) -> middleware(['auth', 'verified']) -> name('admin.dashboard');
    Route::get('/applications', [ApplicationsController::class, 'applications']) -> middleware(['auth', 'verified']) -> name('admin.applications');
    Route::post('/post-new-app', [ApplicationsController::class, 'post_new_app']) -> middleware(['auth', 'verified']) -> name('admin.post-new-app');
    Route::post('/edit-app', [ApplicationsController::class, 'edit_app']) -> middleware(['auth', 'verified']) -> name('admin.edit-app');
    Route::get('/app-info/{identifier}', [ApplicationsController::class, 'application_info']) -> middleware(['auth', 'verified']) -> name('admin.app-info');
    Route::get('/new-app', [ApplicationsController::class, 'new_application']) -> middleware(['auth', 'verified']) -> name('admin.new-application');
    Route::get('/clients-requests', [ApplicationsController::class, 'AppRequests']) -> middleware(['auth', 'verified']) -> name('admin.requests');
    Route::get('/clients-requests/{app_id}', [ApplicationsController::class, 'requestsReview']) -> middleware(['auth', 'verified']) -> name('admin.request-review');
    Route::get('/delete-app', [ApplicationsController::class, 'delete_application']) -> middleware(['auth', 'verified']) -> name('admin.delete-app');
    Route::get('/revenue', [AdminController::class, 'revenue']) -> middleware(['auth', 'verified']) -> name('admin.revenue');
    Route::get('/org/applications', [AdminController::class, 'organization']) -> middleware(['auth', 'verified']) -> name('admin.org');
    Route::get('/org/members/{member}', [AdminController::class, 'org_member']) -> middleware(['auth', 'verified']) -> name('admin.member');
    Route::get('/organization/it/{member}', [AdminController::class, 'org_it_member']) -> middleware(['auth', 'verified']) -> name('admin.it-member');
    Route::get('/hire', [AdminController::class, 'hire']) -> middleware(['auth', 'verified']) -> name('admin.hire');
    Route::post('/hire-emp', [AdminController::class, 'hire_emp']) -> middleware(['auth', 'verified']) -> name('admin.hire-emp');
    Route::get('/fire-emp/{emp}', [AdminController::class, 'fire_emp']) -> middleware(['auth', 'verified']) -> name('admin.fire-emp');
    Route::get('/ads', [AdminController::class, 'ads']) -> middleware(['auth', 'verified']) -> name('admin.ads');
    Route::get('/publish-add', [AdminController::class, 'publish_add']) -> middleware(['auth', 'verified']) -> name('admin.publish-add');
    Route::post('/post-add', [AdminController::class, 'post_add']) -> middleware(['auth', 'verified']) -> name('admin.post-add');
    Route::get('/ads/{add_id}', [AdminController::class, 'add_info']) -> middleware(['auth', 'verified']) -> name('admin.add-info');
    Route::post('/ads/update/', [AdminController::class, 'update_ad']) -> middleware(['auth', 'verified']) -> name('admin.update-ad');
    Route::get('/ads/activate/{ad_id}', [AdminController::class, 'activateAd']) -> middleware(['auth', 'verified']) -> name('admin.activate');
    Route::get('/ads/disactivate/{ad_id}', [AdminController::class, 'disactivateAd']) -> middleware(['auth', 'verified']) -> name('admin.disactivate');
    Route::get('/ads/delete/{ad_id}', [AdminController::class, 'delete_ad']) -> middleware(['auth', 'verified']) -> name('admin.delete-ad');
    Route::get('/transfer', [AdminController::class, 'transfer']) -> middleware(['auth', 'verified']) -> name('admin.transfer');
    Route::get('/assistance-requests', [AdminController::class, 'assistance_requests']) -> middleware(['auth', 'verified']) -> name('admin.assistance-requests');
    Route::post('/assistance-requests/reply', [PagesController::class, 'request_reply']) -> middleware(['auth', 'verified']) -> name('request-reply');
    Route::get('/community', [AdminController::class, 'community']) -> middleware(['auth', 'verified']) -> name('admin.com');
    Route::get('/community/clients/{client}', [AdminController::class, 'client_info']) -> middleware(['auth', 'verified']) -> name('admin.client-info');
    Route::get('/sheets/{assistant}', [AdminController::class, 'recordings']) -> middleware(['auth', 'verified']) -> name('admin.sheet');
    Route::get('/sheets/{assistant}/this-week', [AdminController::class, 'recordings']) -> middleware(['auth', 'verified']) -> name('admin.sort-recs-this-week');
    Route::get('/sheets/{assistant}/all', [AdminController::class, 'sortRecsAll']) -> middleware(['auth', 'verified']) -> name('admin.sort-recs-all');
    Route::post('/pay-assistant', [AdminController::class, 'assistantPayment']) -> middleware(['auth', 'verified']) -> name('admin.pay-assistant');
    Route::get('/profile', [ProfileController::class, 'edit']) -> middleware(['auth', 'verified']) ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update']) -> middleware(['auth', 'verified']) ->name('admin.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy']) -> middleware(['auth', 'verified']) -> name('profile.destroy');
    Route::get('/revenue/debtors', [AdminController::class, 'debtors']) -> middleware(['auth', 'verified']) -> name('debtors');
    Route::post('/invalidate-emp', [AdminController::class, 'invalidate_employee']) -> middleware(['auth', 'verified']) -> name('admin.invalidate-emp');
    Route::post('/invalidate-it-emp', [AdminController::class, 'invalidate_it_employee']) -> middleware(['auth', 'verified']) -> name('admin.invalidate-it-emp');
    Route::get('/validate-emp', [AdminController::class, 'validate_employee']) -> middleware(['auth', 'verified']) -> name('admin.validate-emp');
    Route::get('/validate-it-emp', [AdminController::class, 'validate_it_employee']) -> middleware(['auth', 'verified']) -> name('admin.validate-it-emp');
    Route::get('/org/dev-dept', [AdminController::class, 'rba']) -> middleware(['auth', 'verified']) -> name('admin.rba');
    Route::patch('/update-staff', [ProfileController::class, 'update_staff_profile']) -> middleware(['auth', 'verified']) -> name('update-staff-info');
    Route::patch('/update-dev', [ProfileController::class, 'update_rhythmbox_profile']) -> middleware(['auth', 'verified']) -> name('update-dev-info');
    Route::put('/change-dev-password', [PasswordController::class, 'change_dev_password']) -> middleware(['auth', 'verified']) -> name('dev.password.update');
    Route::put('/change-staff-password', [PasswordController::class, 'change_staff_password']) -> middleware(['auth', 'verified']) -> name('staff.password.update');
    Route::get('/testmonials', [PagesController::class, 'testimonies'])-> middleware(['auth', 'verified']) -> name('testimonies');
    Route::get('/edit-testmony/{testmony}', [PagesController::class, 'edit_testmony_form']) -> name('edit-testmony');
    Route::post('/edit-testmony-info', [PagesController::class, 'edit_testmony']) -> middleware(['auth', 'verified']) -> name('edit-testmony-info');
    Route::get('/delete-testmony/{id}/{file}', [PagesController::class, 'delete_testmony']) -> middleware(['auth', 'verified']) -> name('delete-testmony');
    Route::get('/new-testmony', function () { return view('admin.new-testmony'); }) -> middleware(['auth', 'verified']) -> name('new-testmony');
    Route::post('/post-testmony', [PagesController::class, 'post_testmony']) -> middleware(['auth', 'verified']) -> name('post-testmony');
    Route::get('/faqs', [PagesController::class, 'faqs']) -> middleware(['auth', 'verified']) -> name('faqs');
    Route::post('/edit-faq', [PagesController::class, 'edit_faqs']) -> middleware(['auth', 'verified']) -> name('edit-faq');
    Route::post('/post-faq', [PagesController::class, 'post_faqs']) -> middleware(['auth', 'verified']) -> name('post-faq');
    Route::get('/delete-faq/{id}', [PagesController::class, 'delete_faq']) -> middleware(['auth', 'verified']) -> name('delete-faq');
    Route::get('/parteners', [AdminController::class, 'parteners']) -> middleware(['auth', 'verified']) -> name('admin.parteners');
    Route::post('/invalidate-partner', [AdminController::class, 'invalidate_partner']) -> middleware(['auth', 'verified']) -> name('admin.invalidate-partner');
    Route::get('/validate-partner', [AdminController::class, 'validate_partner']) -> middleware(['auth', 'verified']) -> name('admin.validate-partner');
    Route::post('/disburse-full-to-partner', [AdminController::class, 'disburse_full_to_partner']) -> name('admin.disburse-full-to-partner');
    Route::post('/disburse-partial-to-partner', [AdminController::class, 'disburse_partial_to_partner']) -> name('admin.disburse-partial-to-partner');
  	Route::get('/assess/{customer_info}/{application_info}', [AdminController::class, 'deleted_details']) -> name('assess');
  	Route::get('/recycle', [AdminController::class, 'recycle_bin']) -> name('recycle');
  	Route::get('/recover/{application_id}', [AdminController::class, 'recover_request']) -> name('recover');
  	Route::get('/recover/{customer_info}/{application_info}', [AdminController::class, 'recover_deleted']) -> name('recovery');
  	Route::get('/confirm-d/{application_id}', [AdminController::class, 'confirm_delete']) -> name('confirm-d');
});

Route::prefix('md')->middleware('staff', 'strack')->group(function () {
    Route::get('/dashboard', [MdController::class, 'dashboard'])->name('md.dashboard');
    Route::get('/apps', [ApplicationsController::class, 'applications'])->name('md.apps');
    Route::get('/new-app', [ApplicationsController::class, 'new_application']) -> name('md.new-application');
    Route::post('/post-new-app', [ApplicationsController::class, 'post_new_app']) -> name('md.post-new-app');
    Route::get('/app-info/{identifier}', [ApplicationsController::class, 'application_info']) -> name('md.app-info');
    Route::post('/edit-app', [ApplicationsController::class, 'edit_app']) -> name('md.edit-app');
    Route::get('/delete-app', [ApplicationsController::class, 'delete_application']) -> name('md.delete-app');
    Route::get('/app/comments', [ApplicationsController::class, 'comments'])->name('md.app-comments');
    Route::post('/comments/{id}/update-status', [ApplicationsController::class, 'updateStatus']);
    Route::delete('/comments/{id}', [ApplicationsController::class, 'delete']);
    Route::delete('/reply/{Id}/delete', [ApplicationsController::class, 'delete_reply']);
    Route::get('/ads', [AdminController::class, 'ads']) -> name('md.ads');
    Route::get('/subs', [SubscriptionController::class, 'subs']) -> name('md.subs');
    Route::get('/subs/plans', [SubscriptionController::class, 'subs_plans']) -> name('md.subs-plans');
    Route::post('/subs/services/store', [SubscriptionController::class, 'storeService']);
    Route::get('/subs/export', [SubscriptionController::class, 'exportSubsXcel'])->name('subs.export');
    Route::get('/publish-add', [AdminController::class, 'publish_add']) -> name('md.publish-add');
    Route::post('/post-add', [AdminController::class, 'post_add']) -> name('md.post-add');
    Route::get('/ads/{add_id}', [AdminController::class, 'add_info']) -> name('md.add-info');
    Route::post('/ads/update/', [AdminController::class, 'update_ad']) -> name('md.update-ad');
    Route::get('/ads/activate/{ad_id}', [AdminController::class, 'activateAd']) -> name('md.activate');
    Route::get('/ads/disactivate/{ad_id}', [AdminController::class, 'disactivateAd']) -> name('md.disactivate');
    Route::get('/ads/delete/{ad_id}', [AdminController::class, 'delete_ad']) -> name('md.delete-ad');
    Route::get('/testmonials', [PagesController::class, 'testimonies']) -> name('md.testimonies');
    Route::get('/edit-testmony/{testmony}', [PagesController::class, 'edit_testmony_form']) -> name('md.edit-testmony');
    Route::post('/edit-testmony-info', [PagesController::class, 'edit_testmony']) -> name('md.edit-testmony-info');
    Route::get('/delete-testmony/{id}/{file}', [PagesController::class, 'delete_testmony']) -> name('md.delete-testmony');
    Route::get('/new-testmony', function () { return view('admin.new-testmony'); }) -> name('md.new-testmony');
    Route::post('/post-testmony', [PagesController::class, 'post_testmony']) -> name('md.post-testmony');
    Route::get('/faqs', [PagesController::class, 'faqs']) -> name('md.faqs');
    Route::post('/edit-faq', [PagesController::class, 'edit_faqs']) -> name('md.edit-faq');
    Route::post('/post-faq', [PagesController::class, 'post_faqs']) -> name('md.post-faq');
    Route::get('/delete-faq/{id}', [PagesController::class, 'delete_faq']) -> name('md.delete-faq');
    Route::get('/profile', [ProfileController::class, 'edit']) ->name('md.profile.edit');
    Route::get('/apps/{app_id}/comments', [ApplicationsController::class, 'comments_view']) ->name('app.comments');
    Route::post('/app/comments/reply', [ApplicationsController::class, 'comment_reply']) ->name('app.comments.reply');
});

Route::get('/users/{commentId}', [AdminController::class, 'users'])->middleware('staff')->name('users.get');
Route::get('/get-users', [AdminController::class, 'getUsers'])->middleware('staff');
Route::get('/get-user-info/{user}', [AdminController::class, 'getUserInfo'])->middleware('staff');
Route::post('/comments/{commentId}/recommend/', [ApplicationsController::class, 'recommendTo']);
Route::get('/issues/get', [AdminController::class, 'getIssues'])->middleware('staff')->name('messages.get');
Route::get('/issue/{issue}/conv', [AdminController::class, 'getIssueConv'])->middleware('staff')->name('issue.conv');
Route::get('/tags/{issue}/', [AdminController::class, 'getTags'])->middleware('staff')->name('issue.tags');
Route::post('/issue/reply', [AdminController::class, 'issueReply'])->middleware('staff')->name('issue.reply');

Route::get('/subs/services', [SubscriptionController::class, 'subs_services']) -> name('subs-services.get');
Route::get('/subs/services/{plan}', [SubscriptionController::class, 'subs_plan_services'])->name('subs-services-plan.get');
Route::post('/subs/services/add', [SubscriptionController::class, 'addServiceToPlan'])->name('subs-service.add');
Route::delete('/subs/services/remove', [SubscriptionController::class, 'removeServiceFromPlan'])->name('subs-service.remove');
Route::put('/subs/services/update', [SubscriptionController::class, 'updateService'])->name('subs-service.update');
Route::delete('/subs/services/delete', [SubscriptionController::class, 'deleteService'])->name('subs-service.delete');
Route::post('/subs/communicate', [SubscriptionController::class, 'sendMessage'])->name('subs.communicate');
Route::post('/mails/new-app/send', [MailController::class, 'new_app_mail']) -> name('mails.new-app.send');
Route::get('/chats', [ChatsController::class, 'index'])->middleware('staff') -> name('chats.index');
Route::post('/update', [AdminController::class, 'updateModels']) -> name('models.update');

Route::get('/rhythmbox', function () {
    return redirect() -> route('rhythmbox.dashboard');
});

Route::get('/rba', function () {
    return redirect() -> route('rhythmbox.dashboard');
});

Route::prefix('rhythmbox') -> middleware('rhythmbox', 'atrack') -> group(function () {
    Route::get('/profile', [ProfileController::class, 'edit_profile'])->name('rhythm.profile');
	Route::get('/disbursements', [RhythmBoxController::class, 'disbursements'])->name('rhythm.disbursements');
    Route::patch('/profile', [ProfileController::class, 'update_rhythmbox_profile'])->name('dev.profile.update');
    Route::post('/partner-update-profile-pic', [ProfileController::class, 'partner_update_profile_pic'])->name('partner-update-profile-pic');
    Route::delete('/profile', [ProfileController::class, 'destroy']) -> name('profile.destroy');
    Route::put('/change-password', [PasswordController::class, 'change_dev_password']) -> name('rb.password.update');
    Route::get('/dashboard', [RhythmBoxController::class, 'dashboard']) -> name('rhythmbox.dashboard');
    Route::get('/org', [RhythmBoxController::class, 'org']) -> name('rhythmbox.records');
    Route::get('/sheets/{assistant}', [RhythmBoxController::class, 'recordings']) -> name('rhythmbox.sheet');
    Route::get('/sheets/{assistant}/this-week', [RhythmBoxController::class, 'recordings']) -> name('rhythmbox.sort-recs-this-week');
    Route::get('/sheets/{assistant}/all', [RhythmBoxController::class, 'sortRecsAll']) -> name('rhythmbox.sort-recs-all');
    Route::get('/admin', [RhythmBoxController::class, 'admin']) -> name('rhythmbox.admin');
    Route::get('/rba', [RhythmBoxController::class, 'rba']) -> name('rba');

  	Route::get('/recyclebin', [RhythmBoxController::class, 'recycle_bin']) -> name('rhythmbox.recycle');
  	Route::get('/recover/{customer_info}/{application_info}', [RhythmBoxController::class, 'recover_deleted']) -> name('recovery');
});

Route::get('/staffpanel', function () {
    return redirect() -> route('staff-dashboard');
});

Route::get('/staff-disbursements/{assistant}', [PagesController::class, 'staff_disbursements']) -> name('staff.disbursements');

Route::prefix('staff') -> middleware('staff', 'strack') -> group(function () {

    Route::get('/dashboard', [StaffController::class, 'staff_dashboard']) -> name('staff-dashboard');
    Route::get('/customer-details/{customer_info}/{application_info}', [StaffController::class, 'customer_details']) -> name('customer-details');
    Route::get('/record-activity', [StaffController::class, 'record_activity']) -> name('record-activity');
    Route::get('/mark-application-complete/{application_id}', [StaffController::class, 'mark_application_as_complete']) -> name('mark-application-complete');
    Route::get('/delete-request/{application_id}', [StaffController::class, 'delete_request']) -> name('delete-request');
    Route::get('/begin-application', [StaffController::class, 'begin_application']) -> name('begin-application');
    Route::post('/postponed-data/{application_id}', [StaffController::class, 'postponed_data']) -> name('postponed-data');
    Route::get('/resume-application/{customer_info}/{application_info}', [StaffController::class, 'resume_application']) -> name('resume-application');
    Route::get('/reconsider-application/{customer_info}/{application_info}', [StaffController::class, 'reconsider_application']) -> name('reconsider-application');
    Route::get('/resume-postponed-application/{application_info}', [StaffController::class, 'resume_postponed_application']) -> name('resume-postponed-application');
    Route::post('/completed-app-data/{application_id}', [StaffController::class, 'completed_app_data']) -> name('completed-app-data');
    Route::post('/record-new-activity', [StaffController::class, 'record_new_activity']) -> name('record-new-activity');
    Route::post('/mark-debtor-as-paid', [StaffController::class, 'mark_debtor_as_paid']) -> name('mark-debtor-as-paid');
    Route::post('/mark-partial-payment', [StaffController::class, 'mark_partial_payment']) -> name('mark-partial-payment');
    Route::get('/worksheet/this-week', [StaffController::class, 'recordings']) -> name('sort-recs-this-week');
    Route::get('/worksheet/all', [StaffController::class, 'sortRecsAll']) -> name('sort-recs-all');
    Route::post('/mark-as-greed', [StaffController::class, 'mark_as_greed']) -> name('mark-as-greed');
    Route::post('/remind-to-pay', [StaffController::class, 'remind_to_pay']) -> name('remind-to-pay');
    Route::get('/debtor-details/{debtor_info}', [StaffController::class, 'debtor_details']) -> name('debtor-details');
    Route::post('/add-client-app', [StaffController::class, 'add_client_app']) -> name('add-client-app');
    Route::get('/assistance-requests', [StaffController::class, 'assistance_requests']) -> name('assistance-requests');
    Route::post('/request-reply', [PagesController::class, 'request_reply']) -> name('staff.request-reply');
    Route::post('staff-create-client', [ClientAuthController::class, 'staff_create_client']) -> name('staff-create-client');
    Route::post('/client-info-update', [PagesController::class, 'profile_info_update']) -> name('client-info-update');
    Route::get('/profile', [ProfileController::class, 'edit']) ->name('staff.profile.edit');

  	Route::get('/unreachable/{application_id}/{applicant}', [StaffController::class, 'unreachable']) -> name('unreachable');
  	Route::post('/request-to-pay', [StaffController::class, 'request_to_pay']) -> name('request-to-pay');


});

Route::get('/failed-session', function () {
    return view('staff.fired-member-notify');
}) -> name('fired-staff-notify');


Route::get('rhythmbox-logout', [AuthenticatedSessionController::class, 'rhythmbox_destroy']) -> name('rhythmbox.logout');
Route::get('staff-logout', [AuthenticatedSessionController::class, 'staff_destroy']) -> name('staff.logout');
Route::post('error', function () {return view('error');}) -> name('error');
Route::get('notice', function () {return view('error');}) -> name('notice');

Route::post('/send-email', 'App\Http\Controllers\Dev\SendEmailController@sendEmail')->name('send.email');

require __DIR__.'/auth.php';

Route::prefix('accountant') -> group(function () {
    Route::get('/dashboard', [AccountabilityController::class, 'accountant_dashboard']) -> name('accountant-dashboard');
    Route::get('/transactions', [AccountabilityController::class, 'pending_transactions']) -> name('pending-transactions');
    Route::post('/approve/{application_id}', [AccountabilityController::class, 'approve_transaction'])->name('approve-transaction');
    Route::get('/review/{transaction}/{applicant}/{application}/{agent}', [AccountabilityController::class, 'transaction_review']) -> name('transaction-review');
    Route::get('/debtors', [AccountabilityController::class, 'accountant_deptors']) -> name('accountant-deptors');
    Route::get('/complete-transactions', [AccountabilityController::class, 'complete_transactions']) -> name('complete-transactions');
    Route::get('/accountant/staff', [AdminController::class, 'organization']) -> name('accountant-staff');
    Route::get('/sheets/{assistant}', [AdminController::class, 'recordings']) -> name('employer-sheet');
    Route::get('/sheets/{assistant}/this-week', [AdminController::class, 'recordings']) -> name('accountant-sort-recs-this-week');
    Route::get('/sheets/{assistant}/all', [AdminController::class, 'sortRecsAll']) -> name('accountant-sort-recs-all');
    Route::get('/sort-pending-applications', [AccountabilityController::class, 'sort_pending_applications']) -> name('sort-pending-apps');
    Route::get('/sort-complete-applications', [AccountabilityController::class, 'complete_transactions']) -> name('sort-complete-apps');
    Route::get('/accountant-revenues', [AdminController::class, 'revenue']) -> name('accountant.revenue');
    Route::get('/revenue/debtors', [AdminController::class, 'debtors']) -> name('debtors');
    Route::get('/accountant/export-transactions', [ExportsController::class, 'exportTransactions'])->name('export.transactions');
    Route::get('/export-revenue', [AccountabilityController::class, 'revenue']) -> name('export-revenues');
    Route::get('/accountant-remind', [AccountabilityController::class, 'remind_debtor']) -> name('remind-debtor');
});
