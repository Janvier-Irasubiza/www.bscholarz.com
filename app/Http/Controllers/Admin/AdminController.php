<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RhythmBox;
use App\Models\Staff;
use App\Models\User;
use App\Models\Comment;
use Carbon\Carbon;
use DB;
use File;
use Mail;
use App\Mail\DisbursedSalary;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller {

    public function login() {

        if (!Auth::user()) {
            return view('auth.admin-auth');
        }

        else {
            return redirect() -> route('admin.dashboard');
        }

    }

    public function dashboard() {

        $userRequestCount = Cache::remember('user_request_count', now()->addMinutes(10), function () {
            return DB::table('user_requests')
                ->where('payment_status', 'Not yet paid')
                ->where('application_status', 'Pending')
                ->count();
        });

        $readyCustomerCount = Cache::remember('ready_customer_count', now()->addMinutes(10), function () {
            return DB::table('user_requests')
                ->where('application_status', 'Pending')
                ->count();
        });

        $servedCustomerCount = Cache::remember('served_customer_count', now()->addMinutes(10), function () {
            return DB::table('served_requests')
                ->where('payment_status', 'Paid')
                ->where('application_status', 'Complete')
                ->count();
        });

        $activeEmployeeCount = Cache::remember('active_employee_count', now()->addMinutes(10), function () {
            return DB::table('staff')
                ->where('status', 'Online')
                ->count();
        });

        $assistanceRequestCount = Cache::remember('assistance_request_count', now()->addMinutes(10), function () {
            return DB::table('assistance_seekings')
                ->whereNull('assistance_given')
                ->count();
        });

        $requestedDeleteCount = Cache::remember('requested_delete_count', now()->addMinutes(10), function () {
            return DB::table('user_requests')
                ->where('deletion_status', 'Requested')
                ->count();
        });

        $applicationCount = Cache::remember('application_count', now()->addMinutes(10), function () {
            return DB::table('disciplines')
            ->where('category', '<>', 'Custom')
            ->where('due_date', '>', now()->format('Y-m-d H:i:s.u'))
            ->count();
        });

        $deadlinedAppsCount = Cache::remember('deadlined_apps_count', now()->addMinutes(10), function () {
            return DB::table('disciplines')
            ->where('category', '<>', 'Custom')
            ->where('due_date', '<', now()->format('Y-m-d H:i:s.u'))
            ->count();
        });

        return view('admin.dashboard', compact(
            'applicationCount',
            'userRequestCount',
            'readyCustomerCount',
            'servedCustomerCount',
            'activeEmployeeCount',
            'assistanceRequestCount',
            'requestedDeleteCount',
            'deadlinedAppsCount'
        ));
    }

    public function assistance_requests() {
        $assistanceRequests = Cache::remember('assistance_requests', now()->addMinutes(10), function () {
            return DB::table('assistance_seekings')
                ->whereNull('assistance_given')
                ->orderBy('posted_on', 'DESC')
                ->paginate(10);
        });

        return view('admin.assistance-requests', ['assistanceRequests' => $assistanceRequests]);
    }


  	public function deleted_details (Request $request) {

      	date_default_timezone_set('Africa/Kigali');

        $client_info = DB::table('applicant_info') -> where('id', $request -> customer_info) -> first();
        $client_background = DB::table('applicant_education_info') -> where('applicant', $request -> customer_info) -> get();
        $client_docs = DB::table('applicant_documents') -> where('applicant', $request -> customer_info) -> get();
        $application_requested = DB::table('user_requests') -> where('application_id', $request -> application_info) -> where('id', $request -> customer_info) -> first();
        $applications_items = DB::table('applications') -> where('app_id', $request -> application_info) -> where('applicant', $request -> customer_info) -> first();
        $all_details = DB::table('served_requests') -> where('id', $request -> customer_info) -> where('amount_not_paid', '<>', 0) -> where('deliberation', 'Refused to pay') -> get();

        //DB::table('applications') -> where('app_id', $request -> application_info) -> limit(1) -> update(['status' => 'Under Review', 'revied_by' => Auth::guard('staff') -> user() -> id, 'revied_on' => date('Y-m-d H:m:s') , 'review_ccl' => 'yes']);

        //$under_review = DB::table('user_requests') -> where('status', 'Under Review') -> where('revied_by', Auth::guard('staff') -> user() -> id) -> get();


        return view('admin.delete-details', compact('client_info', 'client_background', 'client_docs', 'application_requested', 'applications_items', 'all_details'));
    }


  	public function recycle_bin () {

      $requested_delete = DB::table('user_requests') -> where('deletion_status', 'Deletion Confirmed') -> get();

      return view('admin.recycle', compact('requested_delete'));

    }


  	public function recover_request (Request $request) {

        DB::table('applications') -> where('app_id', $request -> application_id) -> update(['deletion_status' => NULL, 'deleted_on' => NULL]);


        return redirect() -> route('admin.dashboard');
    }


  	public function recover_deleted (Request $request) {

        DB::table('applications') -> where('applicant', $request -> customer_info) -> where('app_id', $request -> application_info) -> update(['deletion_status' => NULL, 'deleted_on' => NULL]);


        return redirect() -> route('recycle');
    }


  	public function confirm_delete (Request $request) {

        DB::table('applications') -> where('app_id', $request -> application_id) -> update(['deletion_status' => 'Deletion Confirmed', 'deleted_on' => Carbon::now()]);


        return redirect() -> route('admin.dashboard');
    }

    public function revenue() {
        $app_incomes = DB::table('served_requests') -> where('payment_status', 'Paid') -> where('application_status', 'Complete') -> get();
        $todayApps = DB::table('served_requests') -> where('payment_status', 'Paid') -> where('application_status', 'Complete') -> whereDate('served_on', Carbon::today()) -> get();
        $todayAds = DB::table('adverts') -> whereDate('posted_on', Carbon::today()) -> get();

        $ads = DB::table('adverts') -> where('status', 'active') -> get();
        return view('admin.revenue', compact('app_incomes', 'ads', 'todayApps', 'todayAds'));
    }

    public function organization() {
        $staff = DB::table('staff') -> where('department', '<>', 'Development') -> get();
        return view('admin.org', compact('staff'));
    }

    public function parteners() {

        $parteners = DB::table('rhythmbox') -> get();

      	foreach($parteners as $partner) {

      		$history = DB::table('partners_payment_history') -> where('paid_to', $partner -> id) -> orderBy('paid_at', 'DESC') -> get();

        }

        return view('admin.parteners', compact('parteners', 'history'));
    }

    public function hire() {
        return view('admin.hire');
    }

    public function hire_emp(Request $request) {

            $request -> validate([
                'names' => ['required'],
                'email' => ['required', 'unique:'.Staff::class],
                'phone_number' => ['required'],
                'work_phone' => ['required'],
                'department' => ['required'],
                'role' => ['required'],
                'percentage' => ['required_if:department,Applications'],
                'password' => ['required', 'confirmed']
            ]);

            if ($request -> department == 'IT' || $request -> department == 'It' || $request -> department == 'it' || $request -> department == 'Development' || $request -> department == 'development' || $request -> department == 'Software Development' || $request -> department == 'software development' || $request -> department == 'Software development' || $request -> department == 'software Development' || $request -> department == 'software' || $request -> department == 'Software') {

                $data = [
                    'names' => $request -> names,
                    'email' => $request -> email,
                    'phone_number' => $request -> phone_number,
                    'department' => 'Development',
                    'role' => $request -> role,
                    'percentage' => $request -> percentage,
                  	'work_phone' => $request -> work_phone,
                    'password' => Hash::make($request -> password),
                    'profile_picture' => 'profile.png'
                ];

                DB::table('staff') -> insert($data);

                return redirect() -> route('admin.rba');

            }

            else {

                $data = [
                    'names' => $request -> names,
                    'email' => $request -> email,
                    'phone_number' => $request -> phone_number,
                    'department' => $request -> department,
                    'role' => $request -> role,
                    'percentage' => $request -> percentage,
                  	'work_phone' => $request -> work_phone,
                    'password' => Hash::make($request -> password),
                    'profile_picture' => 'profile.png'
                ];

                DB::table('staff') -> insert($data);

                return redirect() -> route('admin.org');

            }

    }

    public function org_member(Request $request) {
        $member = DB::table('staff') -> where('id', $request -> member) -> first();
        return view('admin.org-member', compact('member'));
    }

    public function org_it_member(Request $request) {
        $member = DB::table('rhythmbox') -> where('id', $request -> member) -> first();
        $dept = 'IT';
        return view('admin.org-member', compact('member', 'dept'));
    }

    public function recordings(Request $request) {

        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);

        $member = DB::table('staff') -> where('id', $request -> assistant) -> first();
        $completedApp = DB::table('served_requests') -> where('assistant', $request -> assistant) -> where('application_status', 'Complete') -> whereBetween('served_on', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]) -> orderBy('served_on', 'desc') -> get();
        $balance = DB::table('served_requests') -> where('assistant', $request -> assistant) -> where('application_status', 'Complete') -> get();
        $history = DB::table('disbursement_history') -> where('assistant', $request -> assistant) -> limit(2) -> orderBy('date_time', 'DESC') -> get();
        return view('admin.sheet', compact('member', 'completedApp', 'balance', 'history'));
    }

    public function sortRecsAll(Request $request) {
        $member = DB::table('staff') -> where('id', $request -> assistant) -> first();
        $completedApp = DB::table('served_requests') -> where('assistant', $request -> assistant) -> where('application_status', 'Complete') -> orderBy('served_on', 'desc') -> get();
      	$history = DB::table('disbursement_history') -> where('assistant', $request -> assistant) -> limit(2) -> orderBy('date_time', 'DESC') -> get();

      	return view('admin.sheet-all-apps', compact('member', 'completedApp', 'history'));
    }

    public function assistantPayment(Request $request) {

        $request -> validate ([
            'app' => ['required']
        ]);

      	$amount_disbursed = 0;

        foreach($request -> app as $key => $app_id) {

            $assistant_app = DB::table('applications') -> where('app_id', $app_id) -> where('assistant', $request -> assistant) -> first();

            $amount_tobe_paid = $assistant_app -> assistant_pending_commission;
          	$amount_disbursed += $amount_tobe_paid;

            DB::table('applications') -> where('assistant', $request -> assistant) -> where('app_id', $app_id) -> limit(1) -> update(['assistant_paid_commission' => $amount_tobe_paid, 'assistant_pending_commission' => 0, 'remittance_status' => 'Paid']);
        }

      	$dib_data = [
          'assistant' => $request -> assistant,
          'amount_disbursed' => $amount_disbursed,
          'date_time' => now()->format('Y-m-d H:i:s.u'),
        ];

      	DB::table('disbursement_history') -> insert($dib_data);

        $staff = DB::table('staff') -> where('id', $request -> assistant) -> first();
        $amt_rem = DB::table('served_requests') -> where('assistant', $request -> assistant) -> where('assistant_pending_commission', '>', 0) -> where('remittance_status', 'on hold') -> get();
        $balance = $amt_rem -> sum('assistant_pending_commission');
        $staff_names = $staff -> names;
        $phone_number = $staff -> phone_number;

        Mail::to($staff -> email) -> send(new DisbursedSalary($staff_names, $amount_disbursed, $balance, $phone_number));

        return back();
    }

    public function disburse_full_to_partner(Request $request) {

        if(DB::table('partners_payment_history') -> insert([
            'paid_amount' => $request -> full_amount,
          	'outstanding_amount' => 0,
            'paid_to' => $request -> partner,
        ])) {

            DB::table('rhythmbox') -> limit(1) -> where('id', $request -> partner) -> update(['pending_amount' => 0, 'outstanding_amount' => 0]);

        }

        return back();
    }

    public function disburse_partial_to_partner(Request $request) {

        $partner = DB::table('rhythmbox') -> where('id', $request -> partner) -> first();

        if(DB::table('partners_payment_history') -> insert([
            'paid_amount' => $request -> partial_amount,
            'outstanding_amount' => $partner -> pending_amount - $request -> partial_amount,
            'paid_to' => $request -> partner,
        ])) {

            DB::table('rhythmbox') -> limit(1) -> where('id', $request -> partner) -> update(['pending_amount' => $partner -> pending_amount - $request -> partial_amount]);

        }

        return back();
    }

    public function fire_emp (Request $request) {

        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);

        DB::table('staff') -> where('id', $request -> emp) -> limit(1) -> delete();
        return redirect() -> route('admin.org');
    }

    public function ads() {
        $ads = DB::table('adverts') -> get();
        $todayAds = DB::table('adverts') -> whereDate('posted_on', Carbon::today()) -> get();
        return view('admin.ads', compact('ads', 'todayAds'));
    }

    public function publish_add() {
        return view('admin.post-add');
    }

    public function post_add(Request $request) {

        $request -> validate([
            'title' => ['required'],
            'owner' => ['required'],
            'owner_phone' => ['required'],
            'ad_type' => ['required'],
            'amount' => ['required'],
            'payment_cycle' => ['required'],
            'ex_date' => ['required'],
            'status' => ['required'],
            // 'media' => ['required', 'mimes:jpg,jpeg,png,gif,svg|max:5048'],
        ]);

        $mediaName = time().'-'.$request -> file('media') -> getClientOriginalName();
        $mediaType = $request -> file('media') -> getMimeType();
        $request -> file('media') -> move(public_path('ads/'), $mediaName);

        $advertData = [
            'title' => $request -> title,
            'owner' => $request -> owner,
            'owner_phone' => $request -> owner_phone,
            'type' => $request -> ad_type,
            'amount' => $request -> amount,
            'payment_circle' => $request -> payment_cycle,
            'expiry_date' => $request -> ex_date,
            'media' => $mediaName,
            'media_type' => $mediaType,
            'status' => $request -> status
        ];

        DB::table('adverts') -> insert($advertData);

        return Auth::user() ? redirect() -> route('admin.ads') : redirect() -> route('md.ads');

    }

    public function add_info(Request $request) {
        $ad = DB::table('adverts') -> where('id', $request -> add_id) -> first();
        return view('admin.add-info', compact('ad'));
    }

    public function update_ad (Request $request) {

        $request -> validate([
            'title' => ['required'],
            'owner' => ['required'],
            'owner_phone' => ['required'],
            'ad_type' => ['required'],
            'amount' => ['required'],
            'payment_cycle' => ['required'],
            'ex_date' => ['required'],
            'status' => ['required'],
            // 'media' => ['required', 'mimes:jpg,jpeg,png,gif,svg|max:5048'],
        ]);

        if ($request -> hasFile('media')) {
            $mediaName = time().'-'.$request -> file('media') -> getClientOriginalName();
            $request -> file('media') -> move(public_path('ads/'), $mediaName);

            if (File::exists(public_path('ads/'.$request -> old_media))) {
                File::delete(public_path('ads/'.$request -> old_media));
            }

            $advertData = [
                'title' => $request -> title,
                'owner' => $request -> owner,
                'owner_phone' => $request -> owner_phone,
                'type' => $request -> ad_type,
                'amount' => $request -> amount,
                'payment_circle' => $request -> payment_cycle,
                'expiry_date' => $request -> ex_date,
                'media' => $mediaName,
                'media_type' => $request -> file('media') -> getMimeType(),
                'status' => $request -> status
            ];

            DB::table('adverts') -> where('id', $request -> advert) -> limit(1) -> update($advertData);
        }

        else {
            $advertData = [
                'title' => $request -> title,
                'owner' => $request -> owner,
                'owner_phone' => $request -> owner_phone,
                'type' => $request -> ad_type,
                'amount' => $request -> amount,
                'payment_circle' => $request -> payment_cycle,
                'expiry_date' => $request -> ex_date,
                'media_type' => $request -> file('media') -> getMimeType(),
                'status' => $request -> status
            ];

            DB::table('adverts') -> where('id', $request -> advert) -> limit(1) -> update($advertData);
        }

        return back();
    }

    public function delete_ad(Request $request) {
        DB::table('adverts') -> where('id', $request -> ad_id) -> limit(1) -> delete();
        return back();
    }

    public function activateAd(Request $request) {
        DB::table('adverts') -> where('id', $request -> ad_id) -> limit(1) -> update(['status' => 'active']);
        return back();
    }

    public function disactivateAd(Request $request) {
        DB::table('adverts') -> where('id', $request -> ad_id) -> limit(1) -> update(['status' => 'inactive']);
        return back();
    }

    public function transfer() {
        return view('admin.transfer');
    }

    public function community() {
        $clients = DB::table('applicant_info') -> get();
        return view('admin.com', compact('clients'));
    }

    public function client_info(Request $request) {
        $request_info = DB::table('applicant_info') -> where('id', $request -> client) -> first();
        $edu_info = DB::table('applicant_education_info') -> where('applicant', $request_info -> id) -> get();
        $client_documnent = DB::table('applicant_documents') -> where('applicant', $request_info -> id) -> get();

        $clientAppsRequests = DB::table('user_requests') -> where('id', $request -> client) -> get();
        $clientApps = DB::table('served_requests') -> where('id', $request -> client) -> get();

        return view('admin.client-info', compact('request_info', 'edu_info', 'client_documnent', 'clientApps', 'clientAppsRequests'));
    }

    // debtors
    public function debtors (Request $request) {

            $debtors = DB::table('served_requests') -> where('application_status', 'Complete') -> where('amount_not_paid', '<>', 0) -> where('deliberation', 'Refused to pay') -> orderBy('served_on', 'desc') -> get();

            return view('admin.debtors', compact('debtors'));

        }

    public function rba () {
        $staff = DB::table('staff') -> where('department', 'Development') -> get();
        return view('admin.rba', compact('staff'));
    }

    public function invalidate_employee(Request $request) {

        DB::table('staff') -> limit(1) -> where ('id', $request -> assistant) -> update(['reason_of_invalidation' => $request -> reason, 'working_status' => $request -> decision, 'invalidated_at' => date('Y-m-d H:i:s')]);

        return back();

    }

    public function invalidate_partner(Request $request) {

        DB::table('rhythmbox') -> limit(1) -> where ('id', $request -> partner) -> update(['reason_of_invalidation' => $request -> reason, 'partenership_status' => $request -> decision, 'invalidated_at' => date('Y-m-d H:i:s')]);

        return back();

    }

    public function validate_employee(Request $request) {

        DB::table('staff') -> limit(1) -> where ('id', $request -> assistant) -> update(['reason_of_invalidation' => null, 'working_status' => 'Working', 'invalidated_at' => null]);

        return back();

    }

    public function validate_partner(Request $request) {

        DB::table('rhythmbox') -> limit(1) -> where ('id', $request -> partner) -> update(['reason_of_invalidation' => null, 'partenership_status' => 'Valid', 'invalidated_at' => null]);

        return back();

    }


    public function invalidate_it_employee(Request $request) {

        DB::table('rhythmbox') -> limit(1) -> where ('id', $request -> assistant) -> update(['reason_of_invalidation' => $request -> reason, 'working_status' => $request -> decision, 'invalidated_at' => date('Y-m-d H:i:s')]);

        return back();

    }

    public function validate_it_employee(Request $request) {

        DB::table('rhythmbox') -> limit(1) -> where ('id', $request -> assistant) -> update(['reason_of_invalidation' => null, 'working_status' => 'Working', 'invalidated_at' => null]);

        return back();

    }


    public function accountant_dashboard() {

            $userRequestCount = Cache::remember('user_request_count', now()->addMinutes(10), function () {
                return DB::table('user_requests')
                    ->where('payment_status', 'Not yet paid')
                    ->where('application_status', 'Pending')
                    ->count();
            });

            $readyCustomerCount = Cache::remember('ready_customer_count', now()->addMinutes(10), function () {
                return DB::table('user_requests')
                    ->where('application_status', 'Pending')
                    ->count();
            });

            $servedCustomerCount = Cache::remember('served_customer_count', now()->addMinutes(10), function () {
                return DB::table('served_requests')
                    ->where('payment_status', 'Paid')
                    ->where('application_status', 'Complete')
                    ->count();
            });

            $activeEmployeeCount = Cache::remember('active_employee_count', now()->addMinutes(10), function () {
                return DB::table('staff')
                    ->where('status', 'Online')
                    ->count();
            });

            $assistanceRequestCount = Cache::remember('assistance_request_count', now()->addMinutes(10), function () {
                return DB::table('assistance_seekings')
                    ->whereNull('assistance_given')
                    ->count();
            });

            $requestedDeleteCount = Cache::remember('requested_delete_count', now()->addMinutes(10), function () {
                return DB::table('user_requests')
                    ->where('deletion_status', 'Requested')
                    ->count();
            });

            $applicationCount = Cache::remember('application_count', now()->addMinutes(10), function () {
                return DB::table('disciplines')
                ->where('category', '<>', 'Custom')
                ->where('due_date', '>', now()->format('Y-m-d H:i:s.u'))
                ->count();
            });

            $deadlinedAppsCount = Cache::remember('deadlined_apps_count', now()->addMinutes(10), function () {
                return DB::table('disciplines')
                ->where('category', '<>', 'Custom')
                ->where('due_date', '<', now()->format('Y-m-d H:i:s.u'))
                ->count();
            });

            return view('admin.accountant-dashboard', compact(
                'applicationCount',
                'userRequestCount',
                'readyCustomerCount',
                'servedCustomerCount',
                'activeEmployeeCount',
                'assistanceRequestCount',
                'requestedDeleteCount',
                'deadlinedAppsCount'
            ));
    }


    public function users($commentId) {
        // Fetch all users (staff)
        $users = Staff::all();
    
        // Add 'recommended' attribute to each user based on the specific comment ID
        $usersWithRecommendation = $users->map(function ($user) use ($commentId) {
            // Check if this user is recommended for the specified comment
            $isRecommended = Comment::where('id', $commentId)
                                    ->where('recommended_to', $user->id)
                                    ->exists();
    
            // Add 'recommended' attribute to indicate if the user is recommended for this comment
            $user->recommended = $isRecommended;
    
            return $user;
        });
    
        // Return users
        return response()->json($usersWithRecommendation);
    }       

}
