<?php

namespace App\Http\Controllers\Admin;

use App\Mail\Hired;
use App\Models\Company;
use App\Models\Department;
use App\Models\Discipline;
use App\Models\Request as Applications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Costs;
use Carbon\Carbon;
use DB;
use Mail;
use App\Mail\DisbursedSalary;
use App\Mail\AssistantAppt;
use Illuminate\Support\Facades\Cache;
use App\Models\Advert;
use Illuminate\Support\Str;
use App\Models\Partner;

class AdminController extends Controller
{

    public function login()
    {

        if (!Auth::user()) {
            return view('auth.admin-auth');
        } else {
            return redirect()->route('admin.dashboard');
        }

    }

    public function dashboard()
    {

        $week_start = Carbon::now()->startOfWeek();
        $week_end = Carbon::now()->endOfWeek();

        $revenues = DB::table('applications')->where('payment_status', 'Confirmed')->get();
        $total_revenues = 0;
        foreach ($revenues as $revenue) {
            $assistant_commission = DB::table('staff')->where('id', $revenue->assistant)->select('percentage')->first();
            $total_revenue = ($revenue->amount_paid) - ($revenue->amount_paid * $assistant_commission->percentage / 100);
            $total_revenues += $total_revenue;
        }

        $tdy_revenues = DB::table('applications')->where('payment_status', 'Paid')->whereDate('payment_date', Carbon::today())->get();
        $today_revenues = 0;
        foreach ($tdy_revenues as $t_revenue) {
            $assistant_commission = DB::table('staff')->where('id', $t_revenue->assistant)->select('percentage')->first();
            $today_revenue = ($t_revenue->amount_paid) - ($t_revenue->amount_paid * $assistant_commission->percentage / 100);
            $today_revenues += $today_revenue;
        }

        $week_revenues = DB::table('applications')->where('payment_status', 'Paid')->whereBetween('payment_date', [$week_start, $week_end])->get();
        $this_week_revenues = 0;
        foreach ($week_revenues as $week_revenue) {
            $assistant_commission = DB::table('staff')->where('id', $week_revenue->assistant)->select('percentage')->first();
            $this_week_revenue = ($week_revenue->amount_paid) - ($week_revenue->amount_paid * $assistant_commission->percentage / 100);
            $this_week_revenues += $this_week_revenue;
        }

        $total_requests = DB::table('user_requests')->count();
        $today_requests = DB::table('user_requests')->whereDate('requested_on', Carbon::today())->count();
        $this_week_requests = DB::table('user_requests')->whereBetween('requested_on', [$week_start, $week_end])->count();
        $total_services = DB::table('disciplines')->count();
        $ready_services = DB::table('disciplines')->where('status', 'Available')->count();
        $upcoming_services = DB::table('disciplines')->where('status', 'Upcoming')->orWhere('status', 'Comming Soon')->count();
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

        $appointments = Cache::remember('appointments', now()->addMinutes(10), function () {
            return Applications::where('is_appointment', true)
                ->where('status', 'Pending')
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
            'deadlinedAppsCount',
            'appointments',
            'total_revenues',
            'today_revenues',
            'this_week_revenues',
            'total_requests',
            'today_requests',
            'this_week_requests',
            'total_services',
            'ready_services',
            'upcoming_services',
        ));
    }

    public function assistance_requests()
    {
        $assistanceRequests = Cache::remember('assistance_requests', now()->addMinutes(10), function () {
            return DB::table('assistance_seekings')
                ->whereNull('assistance_given')
                ->orderBy('posted_on', 'DESC')
                ->paginate(10);
        });

        return view('admin.assistance-requests', ['assistanceRequests' => $assistanceRequests]);
    }


    public function deleted_details(Request $request)
    {

        date_default_timezone_set('Africa/Kigali');

        $client_info = DB::table('applicant_info')->where('id', $request->customer_info)->first();
        $client_background = DB::table('applicant_education_info')->where('applicant', $request->customer_info)->get();
        $client_docs = DB::table('applicant_documents')->where('applicant', $request->customer_info)->get();
        $application_requested = DB::table('user_requests')->where('application_id', $request->application_info)->where('id', $request->customer_info)->first();
        $applications_items = DB::table('applications')->where('app_id', $request->application_info)->where('applicant', $request->customer_info)->first();
        $all_details = DB::table('served_requests')->where('id', $request->customer_info)->where('amount_not_paid', '<>', 0)->where('deliberation', 'Refused to pay')->get();

        //DB::table('applications') -> where('app_id', $request -> application_info) -> limit(1) -> update(['status' => 'Under Review', 'revied_by' => Auth::guard('staff') -> user() -> id, 'revied_on' => date('Y-m-d H:m:s') , 'review_ccl' => 'yes']);

        //$under_review = DB::table('user_requests') -> where('status', 'Under Review') -> where('revied_by', Auth::guard('staff') -> user() -> id) -> get();


        return view('admin.delete-details', compact('client_info', 'client_background', 'client_docs', 'application_requested', 'applications_items', 'all_details'));
    }


    public function recycle_bin()
    {

        $requested_delete = DB::table('user_requests')->where('deletion_status', 'Deletion Confirmed')->get();

        return view('admin.recycle', compact('requested_delete'));

    }


    public function recover_request(Request $request)
    {

        DB::table('applications')->where('app_id', $request->application_id)->update(['deletion_status' => NULL, 'deleted_on' => NULL]);


        return redirect()->route('admin.dashboard');
    }


    public function recover_deleted(Request $request)
    {

        DB::table('applications')->where('applicant', $request->customer_info)->where('app_id', $request->application_info)->update(['deletion_status' => NULL, 'deleted_on' => NULL]);


        return redirect()->route('recycle');
    }


    public function confirm_delete(Request $request)
    {

        DB::table('applications')->where('app_id', $request->application_id)->update(['deletion_status' => 'Deletion Confirmed', 'deleted_on' => Carbon::now()]);


        return redirect()->route('admin.dashboard');
    }

    public function revenue()
    {
        $week_start = Carbon::now()->startOfWeek();
        $week_end = Carbon::now()->endOfWeek();

        $revenues = DB::table('applications')->where('payment_status', 'Confirmed')->get();
        $total_revenues = 0;
        foreach ($revenues as $revenue) {
            $assistant_commission = DB::table('staff')->where('id', $revenue->assistant)->select('percentage')->first();
            $total_revenue = ($revenue->amount_paid) - ($revenue->amount_paid * $assistant_commission->percentage / 100);
            $total_revenues += $total_revenue;
        }

        $tdy_revenues = DB::table('applications')->where('payment_status', 'Paid')->whereDate('payment_date', Carbon::today())->get();
        $today_revenues = 0;
        foreach ($tdy_revenues as $t_revenue) {
            $assistant_commission = DB::table('staff')->where('id', $t_revenue->assistant)->select('percentage')->first();
            $today_revenue = ($t_revenue->amount_paid) - ($t_revenue->amount_paid * $assistant_commission->percentage / 100);
            $today_revenues += $today_revenue;
        }

        $week_revenues = DB::table('applications')->where('payment_status', 'Paid')->whereBetween('payment_date', [$week_start, $week_end])->get();
        $this_week_revenues = 0;
        foreach ($week_revenues as $week_revenue) {
            $assistant_commission = DB::table('staff')->where('id', $week_revenue->assistant)->select('percentage')->first();
            $this_week_revenue = ($week_revenue->amount_paid) - ($week_revenue->amount_paid * $assistant_commission->percentage / 100);
            $this_week_revenues += $this_week_revenue;
        }

        $total_requests = DB::table('user_requests')->count();
        $today_requests = DB::table('user_requests')->whereDate('requested_on', Carbon::today())->count();
        $this_week_requests = DB::table('user_requests')->whereBetween('requested_on', [$week_start, $week_end])->count();
        $total_services = DB::table('disciplines')->count();
        $ready_services = DB::table('disciplines')->where('status', 'Available')->count();
        $upcoming_services = DB::table('disciplines')->where('status', 'Upcoming')->orWhere('status', 'Comming Soon')->count();

        $app_incomes = DB::table('served_requests')->where('payment_status', 'Paid')->where('application_status', 'Complete')->get();
        $todayApps = DB::table('served_requests')->where('payment_status', 'Paid')->where('application_status', 'Complete')->whereDate('served_on', Carbon::today())->get();
        $todayAds = DB::table('adverts')->whereDate('posted_on', Carbon::today())->get();

        $ads = DB::table('adverts')->where('status', 'active')->get();
        return view('admin.revenue', compact('total_revenues', 'today_revenues', 'this_week_revenues', 'total_requests', 'today_requests', 'this_week_requests', 'total_services', 'ready_services', 'upcoming_services', 'app_incomes', 'ads', 'todayApps', 'todayAds'));
    }

    public function organization()
    {
        $staff = Staff::with('department')
            ->whereHas('department', function ($query) {
                $query->where('name', '<>', 'Administration');
            })
            ->where('type', '<>', 'admin')->get();
        return view('admin.org', compact('staff'));
    }

    public function parteners()
    {
        $partners = Partner::get();
        return view('admin.partners', compact('partners'));
    }

    public function newPartner()
    {
        return view('admin.new-partner');
    }

    public function addPartner(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'email' => ['required'],
            'phone' => ['required'],
            'description' => ['required'],
            'poster' => ['required', 'mimetypes:image/jpeg,image/png,image/gif,image/svg+xml', 'max:2048'],
            'website' => ['nullable'],
        ]);

        $poster = time() . '-' . $request->file('poster')->getClientOriginalName();
        $request->file('poster')->move(public_path('profile_pictures/'), $poster);

        $partner = new Partner();
        $partner->name = $request->name;
        $partner->email = $request->email;
        $partner->phone = $request->phone;
        $partner->description = $request->description;
        $partner->website = $request->website;
        $partner->poster = $poster;
        $partner->save();

        return back()->with('success', 'New partner added successfully');
    }

    public function editPartner(Request $request)
    {
        $partner = Partner::where('uuid', $request->partner)->first();
        return view('admin.partner-info', compact('partner'));
    }

    public function updatePartner(Request $request)
    {
        $this->validate($request, [
            'partner_id' => ['required'],
            'name' => ['required'],
            'email' => ['required'],
            'phone' => ['required'],
            'description' => ['required'],
            'poster' => ['nullable', 'mimetypes:image/jpeg,image/png,image/gif,image/svg+xml', 'max:2048'],
            'old_poster' => ['required'],
            'website' => ['nullable'],
        ]);

        $partner = Partner::find($request->partner_id);

        if ($request->hasFile('poster')) {

            // Remove the old poster
            $oldPosterPath = public_path('profile_pictures/' . $request->old_poster);
            if (file_exists($oldPosterPath)) {
                unlink($oldPosterPath); // Delete the old file
            }

            // Save the new poster
            $newPosterName = time() . '-' . $request->file('poster')->getClientOriginalName();
            $request->file('poster')->move(public_path('profile_pictures/'), $newPosterName);

            // Update the poster name in the database (example code)
            // Assuming you have a Partner model and updating the poster for a specific partner
            $partner->poster = $newPosterName;
            $partner->save();
        }

        $partner->name = $request->name;
        $partner->email = $request->email;
        $partner->phone = $request->phone;
        $partner->description = $request->description;
        $partner->website = $request->website;
        $partner->save();

        return back()->with('success', 'Partner updated successfully');

    }

    public function deletePartner(Request $request)
    {
        $partner = Partner::find($request->partner);
        $partner->delete();
        return back()->with('success', 'Partner deleted successfully');
    }

    public function activatePartner(Request $request)
    {
        $partner = Partner::find($request->partner);
        $partner->status = 'active';
        $partner->save();
        return back()->with('success', 'Partner activated successfully');
    }

    public function deactivatePartner(Request $request)
    {
        $partner = Partner::find($request->partner);
        $partner->status = 'inactive';
        $partner->save();
        return back()->with('success', 'Partner deactivated successfully');
    }

    public function hire()
    {
        $dpts = Department::all();
        return view('admin.hire', compact('dpts'));
    }

    public function hire_emp(Request $request)
    {

        $request->validate([
            'names' => ['required'],
            'email' => ['required', 'unique:' . Staff::class],
            'phone_number' => ['required'],
            'work_phone' => ['required'],
            'department' => ['required'],
            'role' => ['required'],
            'percentage' => ['required_if:department,Applications'],
            'password' => ['required', 'confirmed']
        ]);

        if ($request->department == 'IT' || $request->department == 'It' || $request->department == 'it' || $request->department == 'Development' || $request->department == 'development' || $request->department == 'Software Development' || $request->department == 'software development' || $request->department == 'Software development' || $request->department == 'software Development' || $request->department == 'software' || $request->department == 'Software') {

            $data = [
                'names' => $request->names,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'department_id' => 'Development',
                'role' => $request->role,
                'percentage' => $request->percentage,
                'work_phone' => $request->work_phone,
                'password' => Hash::make($request->password),
                'profile_picture' => 'profile.png'
            ];

            DB::table('staff')->insert($data);

            return redirect()->route('admin.rba');

        } else {

            $data = [
                'names' => $request->names,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'department_id' => $request->department,
                'role' => $request->role,
                'percentage' => $request->percentage,
                'work_phone' => $request->work_phone,
                'password' => Hash::make($request->password),
                'profile_picture' => 'profile.png'
            ];

            DB::table('staff')->insert($data);

            // Notify Employee

            $data = [
                'emp_names' => $request->names,
                'url' => url(route('staff-dashboard')),
            ];

            Mail::to($request->email)->send(new Hired($data));

            return redirect()->route('admin.org');

        }

    }

    public function org_member(Request $request)
    {
        $member = Staff::with('department')->find($request->member);
        $departments = Department::all();
        return view('admin.org-member', compact('member', 'departments'));
    }

    public function org_it_member(Request $request)
    {
        $member = DB::table('rhythmbox')->where('id', $request->member)->first();
        $dept = 'IT';
        return view('admin.org-member', compact('member', 'dept'));
    }

    public function recordings(Request $request)
    {

        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);

        $member = DB::table('staff')->where('id', $request->assistant)->first();

        $balance = DB::table('served_requests')->where('assistant', $request->assistant)->where('application_status', 'Complete')->get();
        $history = DB::table('disbursement_history')->where('assistant', $request->assistant)->limit(2)->orderBy('date_time', 'DESC')->get();

        // Get filter inputs from the request
        $sortBy = $request->input('sortBy', ''); // e.g., 'name', 'date', etc.
        $employee = $request->employee ?? null; // Staff ID or name
        $application = $request->application ?? null; // Discipline or application status
        $startDate = $request->start_date ?? null; // Start date for filtering
        $endDate = $request->end_date ?? null; // End date for filtering

        try {
            // Fetch the current member
            $member = Staff::find($request->assistant);

            $completedAppQuery = DB::table('served_requests')
                ->where('assistant', $request->assistant)
                ->where('application_status', 'Complete')
                ->whereBetween('served_on', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                ->orderBy('served_on', 'desc');


            // dd($request->all());

            if (!is_null($application)) {
                $completedAppQuery->where('discipline', $application);
            }
            if (!is_null($startDate) && !is_null($endDate)) {
                $completedAppQuery->whereBetween('served_on', [$startDate, $endDate]);
            }

            // Fetch the filtered and sorted results
            $completedApp = $completedAppQuery->paginate(10);

            // Fetch history
            $history = DB::table('disbursement_history')
                ->where('assistant', $request->assistant)
                ->limit(2)
                ->orderBy('date_time', 'DESC')
                ->get();

            // Fetch all employees and applications
            $employees = Staff::all();
            $apps = Discipline::all();

            return view('admin.sheet', compact(
                'member',
                'completedApp',
                'balance',
                'history',
                'employees',
                'sortBy',
                'employee',
                'application',
                'startDate',
                'endDate',
                'apps'
            ));

        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function sortRecsAll(Request $request)
    {
        // Get filter inputs from the request
        $sortBy = $request->input('sortBy', ''); // e.g., 'name', 'date', etc.
        $employee = $request->employee ?? null; // Staff ID or name
        $application = $request->application ?? null; // Discipline or application status
        $startDate = $request->start_date ?? null; // Start date for filtering
        $endDate = $request->end_date ?? null; // End date for filtering

        try {
            // Fetch the current member
            $member = Staff::find($request->assistant);

            // Build query for completed applications
            $completedAppQuery = DB::table('served_requests')
                ->where('assistant', $request->assistant)
                ->where('application_status', 'Complete');

            // dd($request->all());

            if (!is_null($application)) {
                $completedAppQuery->where('discipline', $application);
            }
            if (!is_null($startDate) && !is_null($endDate)) {
                $completedAppQuery->whereBetween('served_on', [$startDate, $endDate]);
            }

            // Fetch the filtered and sorted results
            $completedApp = $completedAppQuery->paginate(10);

            // Fetch history
            $history = DB::table('disbursement_history')
                ->where('assistant', $request->assistant)
                ->limit(2)
                ->orderBy('date_time', 'DESC')
                ->get();

            // Fetch all employees and applications
            $employees = Staff::all();
            $apps = Discipline::all();

            // Return the view with data
            return view('admin.sheet-all-apps', compact(
                'member',
                'completedApp',
                'history',
                'employees',
                'sortBy',
                'employee',
                'application',
                'startDate',
                'endDate',
                'apps'
            ));

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function assistantPayment(Request $request)
    {

        $request->validate([
            'app' => ['required']
        ]);

        $amount_disbursed = 0;

        foreach ($request->app as $key => $app_id) {

            $assistant_app = DB::table('applications')->where('app_id', $app_id)->where('assistant', $request->assistant)->first();

            $amount_tobe_paid = $assistant_app->assistant_pending_commission;
            $amount_disbursed += $amount_tobe_paid;

            DB::table('applications')->where('assistant', $request->assistant)->where('app_id', $app_id)->limit(1)->update(['assistant_paid_commission' => $amount_tobe_paid, 'assistant_pending_commission' => 0, 'remittance_status' => 'Paid']);
        }

        $dib_data = [
            'assistant' => $request->assistant,
            'amount_disbursed' => $amount_disbursed,
            'date_time' => now()->format('Y-m-d H:i:s.u'),
        ];

        DB::table('disbursement_history')->insert($dib_data);

        $staff = DB::table('staff')->where('id', $request->assistant)->first();
        $amt_rem = DB::table('served_requests')->where('assistant', $request->assistant)->where('assistant_pending_commission', '>', 0)->where('remittance_status', 'on hold')->get();
        $balance = $amt_rem->sum('assistant_pending_commission');
        $staff_names = $staff->names;
        $phone_number = $staff->phone_number;

        Mail::to($staff->email)->send(new DisbursedSalary($staff_names, $amount_disbursed, $balance, $phone_number));

        return back();
    }

    public function disburse_full_to_partner(Request $request)
    {

        if (
            DB::table('partners_payment_history')->insert([
                'paid_amount' => $request->full_amount,
                'outstanding_amount' => 0,
                'paid_to' => $request->partner,
            ])
        ) {

            DB::table('rhythmbox')->limit(1)->where('id', $request->partner)->update(['pending_amount' => 0, 'outstanding_amount' => 0]);

        }

        return back();
    }

    public function disburse_partial_to_partner(Request $request)
    {

        $partner = DB::table('rhythmbox')->where('id', $request->partner)->first();

        if (
            DB::table('partners_payment_history')->insert([
                'paid_amount' => $request->partial_amount,
                'outstanding_amount' => $partner->pending_amount - $request->partial_amount,
                'paid_to' => $request->partner,
            ])
        ) {

            DB::table('rhythmbox')->limit(1)->where('id', $request->partner)->update(['pending_amount' => $partner->pending_amount - $request->partial_amount]);

        }

        return back();
    }

    public function fire_emp(Request $request)
    {

        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);

        DB::table('staff')->where('id', $request->emp)->limit(1)->delete();
        return redirect()->route('admin.org');
    }

    public function ads()
    {
        $ads = DB::table('adverts')->get();
        $todayAds = DB::table('adverts')->whereDate('posted_on', Carbon::today())->get();
        return view('admin.ads', compact('ads', 'todayAds'));
    }

    public function publish_add()
    {
        return view('admin.post-add');
    }

    public function post_add(Request $request)
    {

        // Validate request data
        $request->validate([
            'title' => 'required|string|max:255',
            'owner' => 'required|string|max:255',
            'owner_phone' => 'required|string|max:20',
            'ad_type' => 'required|string',
            'amount' => 'required|numeric',
            'payment_cycle' => 'required|string',
            'ex_date' => 'required|date',
            'status' => 'required|string',
            'link' => 'nullable|string|max:255',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,svg|max:5048',
        ]);

        // Initialize file details
        $mediaName = null;
        $mediaType = null;

        // Handle file upload if present
        if ($request->hasFile('media') && $request->file('media')->isValid()) {
            $mediaName = time() . '-' . $request->file('media')->getClientOriginalName();
            $mediaType = $request->file('media')->getMimeType();
            $request->file('media')->move(public_path('ads/'), $mediaName);
        }

        // Prepare data for database insertion
        $advertData = [
            'title' => $request->title,
            'owner' => $request->owner,
            'owner_phone' => $request->owner_phone,
            'type' => $request->ad_type,
            'amount' => $request->amount,
            'payment_circle' => $request->payment_cycle,
            'expiry_date' => $request->ex_date,
            'status' => $request->status,
            'link' => $request->link,
            'media' => $mediaName,
            'media_type' => $mediaType,
        ];

        Advert::create($advertData);

        return Auth::user() ? redirect()->route('admin.ads') : redirect()->route('md.ads');
    }


    public function add_info(Request $request)
    {
        $ad = DB::table('adverts')->where('id', $request->add_id)->first();
        return view('admin.add-info', compact('ad'));
    }

    public function update_ad(Request $request)
    {
        // Validate incoming request
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'owner' => 'required|string|max:255',
                'owner_phone' => 'required|string|max:20',
                'type' => 'required|string',
                'amount' => 'required|numeric',
                'payment_circle' => 'required|string',
                'expiry_date' => 'required|date',
                'status' => 'required|string',
                'link' => 'nullable|string|max:255',
                'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,svg|max:5048',
            ]);

            // // Prepare data for update
            // $advertData = array_filter($validatedData, function($key) {
            //     return $key !== 'media'; // Exclude media from the update array for now
            // }, ARRAY_FILTER_USE_KEY);


            // Initialize file details
            $mediaName = null;
            $mediaType = null;

            // Handle file upload if present
            if ($request->hasFile('media') && $request->file('media')->isValid()) {
                $mediaName = time() . '-' . $request->file('media')->getClientOriginalName();
                $mediaType = $request->file('media')->getMimeType();
                $request->file('media')->move(public_path('ads/'), $mediaName);
            }

            $advertData = [
                'title' => $validatedData['title'],
                'owner' => $validatedData['owner'],
                'owner_phone' => $validatedData['owner_phone'],
                'type' => $validatedData['type'],
                'amount' => $validatedData['amount'],
                'payment_circle' => $validatedData['payment_circle'],
                'expiry_date' => $validatedData['expiry_date'],
                'status' => $validatedData['status'],
                'link' => $validatedData['link'],
                'media' => $mediaName,
                'media_type' => $mediaType,
            ];

            // // Handle file upload if present
            // if ($request->hasFile('media')) {
            //     $mediaName = time() . '-' . $request->file('media')->getClientOriginalName();

            //     if ($request->file('media')->isValid()) {
            //         Storage::disk('ads')->putFileAs('', $request->file('media'), $mediaName);
            //         // Optionally delete the old media if it exists
            //         if ($request->old_media && Storage::disk('ads')->exists($request->old_media)) {
            //             Storage::disk('ads')->delete($request->old_media);
            //         }
            //         $advertData['media'] = $mediaName; // Add media to the update data
            //         $advertData['media_type'] = $request->file('media')->getMimeType(); // Capture MIME type
            //     } else {
            //         return back()->withErrors(['media' => 'The uploaded file is not valid.']);
            //     }
            // }

            // Update advert in the database
            Advert::where('id', $request->advert)->update($advertData);

            return back()->with('success', 'Advert updated successfully.');
        } catch (\Throwable $th) {
            \Log::error("Error sending messages: " . $th->getMessage());
            return back()->with('error', 'An error occurred while updating the advert.' . $th->getMessage());
        }
    }



    public function delete_ad(Request $request)
    {
        DB::table('adverts')->where('id', $request->ad_id)->limit(1)->delete();
        return back();
    }

    public function activateAd(Request $request)
    {
        DB::table('adverts')->where('id', $request->ad_id)->limit(1)->update(['status' => 'active']);
        return back();
    }

    public function disactivateAd(Request $request)
    {
        DB::table('adverts')->where('id', $request->ad_id)->limit(1)->update(['status' => 'inactive']);
        return back();
    }

    public function transfer()
    {
        return view('admin.transfer');
    }

    public function community()
    {
        $clients = DB::table('applicant_info')->get();
        return view('admin.com', compact('clients'));
    }

    public function client_info(Request $request)
    {
        $request_info = DB::table('applicant_info')->where('id', $request->client)->first();
        $edu_info = DB::table('applicant_education_info')->where('applicant', $request_info->id)->get();
        $client_documnent = DB::table('applicant_documents')->where('applicant', $request_info->id)->get();

        $clientAppsRequests = DB::table('user_requests')->where('id', $request->client)->get();
        $clientApps = DB::table('served_requests')->where('id', $request->client)->get();

        return view('admin.client-info', compact('request_info', 'edu_info', 'client_documnent', 'clientApps', 'clientAppsRequests'));
    }

    // debtors
    public function debtors(Request $request)
    {

        $debtors = DB::table('served_requests')->where('application_status', 'Complete')->where('amount_not_paid', '<>', 0)->whereNull('deliberation')->orWhere('deliberation', 'Refused to pay')->orderBy('served_on', 'desc')->get();
        $reminded_debtors = DB::table('served_requests')->where('application_status', 'Complete')->where('amount_not_paid', '<>', 0)->where('deliberation', 'Reminded')->orderBy('served_on', 'desc')->get();

        return view('admin.debtors', compact('debtors', 'reminded_debtors'));

    }

    public function rba()
    {
        $staff = DB::table('staff')->where('department', 'Development')->get();
        return view('admin.rba', compact('staff'));
    }

    public function invalidate_employee(Request $request)
    {

        DB::table('staff')->limit(1)->where('id', $request->assistant)->update(['reason_of_invalidation' => $request->reason, 'working_status' => $request->decision, 'invalidated_at' => date('Y-m-d H:i:s')]);

        return back();

    }

    public function invalidate_partner(Request $request)
    {

        DB::table('rhythmbox')->limit(1)->where('id', $request->partner)->update(['reason_of_invalidation' => $request->reason, 'partenership_status' => $request->decision, 'invalidated_at' => date('Y-m-d H:i:s')]);

        return back();

    }

    public function validate_employee(Request $request)
    {

        DB::table('staff')->limit(1)->where('id', $request->assistant)->update(['reason_of_invalidation' => null, 'working_status' => 'Working', 'invalidated_at' => null]);

        return back();

    }

    public function validate_partner(Request $request)
    {

        DB::table('rhythmbox')->limit(1)->where('id', $request->partner)->update(['reason_of_invalidation' => null, 'partenership_status' => 'Valid', 'invalidated_at' => null]);

        return back();

    }


    public function invalidate_it_employee(Request $request)
    {

        DB::table('rhythmbox')->limit(1)->where('id', $request->assistant)->update(['reason_of_invalidation' => $request->reason, 'working_status' => $request->decision, 'invalidated_at' => date('Y-m-d H:i:s')]);

        return back();

    }

    public function validate_it_employee(Request $request)
    {

        DB::table('rhythmbox')->limit(1)->where('id', $request->assistant)->update(['reason_of_invalidation' => null, 'working_status' => 'Working', 'invalidated_at' => null]);

        return back();

    }


    public function accountant_dashboard()
    {

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

    public function updateModels()
    {
        $this->addUUIDToModels();
    }

    private function addUUIDToModels()
    {

        $models = [
            'App\Models\User',
            'App\Models\Staff',
            'App\Models\Advert',
            'App\Models\Applicant_info',
            'App\Models\Comment',
            'App\Models\CommentReply',
            'App\Models\RhythmBox',
            'App\Models\SubPlan',
            'App\Models\Subscriber',
            'App\Models\SubService',
            'App\Models\Request',
        ];

        $results = [];

        foreach ($models as $model) {
            if (class_exists($model)) {
                $count = 0;

                $model::whereNull('uuid')->chunk(100, function ($records) use (&$count) {
                    foreach ($records as $record) {
                        $record->uuid = Str::uuid();
                        $record->save();
                        $count++;
                    }
                });

                $results[] = [
                    'model' => $model,
                    'status' => 'success',
                    'updated_records' => $count,
                    'message' => $count > 0 ? "Added UUID to {$count} records." : "No records needed UUIDs."
                ];
            } else {
                $results[] = [
                    'model' => $model,
                    'status' => 'error',
                    'updated_records' => 0,
                    'message' => "The model {$model} does not exist."
                ];
            }
        }

        return response()->json($results);
    }

    public function appointments()
    {
        $appointments = Applications::where('is_appointment', 1)->get();
        return view('admin.appointments', compact('appointments'));
    }

    public function appointmentInfo(Request $request)
    {
        $app = Applications::findOrFail($request->appt);
        $assistants = Staff::where('type', '<>', 'admin')->get();
        return view('admin.appointment-info', compact('app', 'assistants'));
    }

    public function updateApptInfo(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'assistant' => 'required|exists:staff,id', // Ensure the assistant exists
            'app_id' => 'required|exists:applications,app_id', // Ensure the application exists
            'time' => 'nullable|date', // Validate time as a date
        ]);

        // Find the application
        $app = Applications::findOrFail($validatedData['app_id']);
        $app->assistant = $validatedData['assistant']; // Assuming 'assistant_id' is the foreign key
        $app->time = $validatedData['time'];
        $app->save();

        // Ensure the assistant relationship is loaded

        // Prepare notification data
        $data = [
            'service' => $app->discipline->discipline_name,
            'client_names' => $app->user->names,
            'client_email' => $app->user->email,
            'client_phone' => $app->user->phone_number,
            'client_address' => $app->address,
            'appt_time' => $app->time,
            'assistant' => $app->appAssistant->names,
        ];

        // Send notification email
        Mail::to($app->appAssistant->email)->send(new AssistantAppt($data));

        return back()->with('success', 'Appointment updated successfully.');
    }


    public function appointmentComplete(Request $request)
    {
        $app = Applications::findOrFail($request->appt);
        $app->status = 'Complete';
        $app->save();
        return back()->with('success', 'Appointment marked as complete successfully.');
    }

    public function undoComplete(Request $request)
    {
        $app = Applications::findOrFail($request->appt);
        $app->status = 'Pending';
        $app->save();
        return back()->with('success', 'Appointment marked as pending successfully.');
    }

    public function appointmentDelete(Request $request)
    {
        $app = Applications::findOrFail($request->appt);
        $app->delete();
        return redirect()->route('admin.appointments')->with('success', 'Appointment deleted successfully.');
    }

    public function webContent()
    {
        $content = Company::first();
        return view('admin.web-content', compact('content'));
    }

    public function updateWebContent(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
            'description' => 'required|string',
            'objectives' => 'required|string',
            'services' => 'required|string',
            'vision' => 'required|string',
            'mission' => 'required|string',
            'goals' => 'required|string',
            'values' => 'required|string',
        ]);

        $webContent = Company::findOrFail($request->id);
        $webContent->description = $request->description;
        $webContent->objectives = $request->objectives;
        $webContent->services = $request->services;
        $webContent->vision = $request->vision;
        $webContent->mission = $request->mission;
        $webContent->goals = $request->goals;
        $webContent->values = $request->values;
        $webContent->save();

        return back()->with('success', 'Web content updated successfully');

    }

    public function set_services_costs(Request $request) {
        $costs = Costs::all();

        return view('admin.services-costs', compact('costs'));
    }

    public function add_new_service_cost(Request $request) {
        return view('admin.add-service-cost');
    }

    public function new_service_cost(Request $request) {
        $this->validate($request, [
            'name' => 'required|string',
            'cost' => 'required|numeric',
        ]);

        Costs::create([
            'service' => $request->name,
            'cost' => $request->cost,
        ]);

        return back()->with('success', 'Service cost added successfully');
    }

    public function delete_service_cost(Request $request) {
        Costs::findOrFail($request->cost)->delete();
        return back()->with('success', 'Service cost deleted successfully');
    }

    public function edit_service_cost(Request $request) {
        $service_cost = Costs::where('id', $request->cost)->first();
        return view('admin.edit-service-cost', compact('service_cost'));
    }

    public function update_service_cost(Request $request) {
        $this->validate($request, [
            'cost_id' => 'required|integer',
            'name' => 'required|string',
            'cost' => 'required|numeric',
        ]);

        Costs::where('id', $request->cost_id)->update([
            'service' => $request->name,
            'cost' => $request->cost,
        ]);

        return back()->with('success', 'Service cost updated successfully');
    }

}
