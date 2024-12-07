<?php

namespace App\Http\Controllers\Accountability;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RhythmBox;
use App\Models\Staff;
use Carbon\Carbon;
use DB;
use File;
use Mail;
use App\Mail\DisbursedSalary;
use App\Mail\Remind;
use Illuminate\Support\Facades\Cache;
use App\Exports\TransactionsExport;
use App\Exports\UnpaidApplicationsExport;
use App\Exports\RevenueExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use App\Models\Message;
use App\Http\Controllers\Notifications;
use App\Http\Controllers\Utils;

class AccountabilityController extends Controller {
    public function accountant_dashboard(Request $request) {
        $clarifications = DB::table('served_requests') -> where('payment_status', 'Agent Needs To Clarify') -> get();

        $week_start = Carbon::now()->startOfWeek();
        $week_end = Carbon::now()->endOfWeek();
        $total_revenues = DB::table('applications') -> where('payment_status', 'Paid') -> sum('amount_paid');
        $today_revenues = DB::table('applications') -> where('payment_status', 'Paid') -> whereDate('payment_date', Carbon::today()) -> sum('amount_paid');
        $this_week_revenues = DB::table('applications') -> where('payment_status', 'Paid') -> whereBetween('payment_date', [$week_start, $week_end]) -> sum('amount_paid');
        $total_requests = DB::table('user_requests') -> count();
        $today_requests = DB::table('user_requests') -> whereDate('requested_on', Carbon::today()) -> count();
        $this_week_requests = DB::table('user_requests') -> whereBetween('requested_on', [$week_start, $week_end]) -> count();
        $total_services = DB::table('disciplines') -> count();
        $ready_services = DB::table('disciplines') -> where('status', 'Available') -> count();
        $upcoming_services = DB::table('disciplines') -> where('status', 'Upcoming') -> orWhere('status', 'Comming Soon') -> count();

        $clarifications_unique = DB::table('served_requests') -> where('payment_status', 'Agent Needs To Clarify') -> groupBy('discipline_identifier', 'discipline_name') -> get();
        $staff_ids = [];
        foreach($clarifications as $app){
            $staff_ids[] = $app -> assistant;
        }
        $employees = DB::table('staff') -> where('role', '!=', 'Accountant') -> where('role', '!=', 'Admin') -> where('role', '!=', 'Marketing') -> whereIn('id', $staff_ids) -> get();

        // Initialize sorting variables with default values
        $sortBy = $request->input('sortBy', '');
        $employee = $request->input('employee', '');
        $application = $request->input('application', '');
        $startDate = $request->input('start_date', '');
        $endDate = $request->input('end_date', '');

        return view('accountant.dashboard', compact('total_revenues', 'today_revenues', 'this_week_revenues', 'total_requests', 'today_requests', 'this_week_requests', 'total_services', 'ready_services', 'upcoming_services', 'clarifications', 'clarifications_unique', 'employees', 'sortBy', 'employee', 'application', 'startDate', 'endDate'));
    }

    public function pending_transactions(Request $request) {
        // $pen_transactions = DB::table('applications') -> where('payment_status', 'Waiting For Review') -> get();
        $applications = DB::table('served_requests') -> where('payment_status', 'Waiting For Review') -> get();
        $applications_unique = DB::table('served_requests') -> where('payment_status', 'Waiting For Review') -> groupBy('discipline_identifier', 'discipline_name') -> get();
        $staff_ids = [];
        foreach($applications as $app){
            $staff_ids[] = $app -> assistant;
        }
        $employees = DB::table('staff') -> where('role', '!=', 'Accountant') -> where('role', '!=', 'Admin') -> where('role', '!=', 'Marketing') -> whereIn('id', $staff_ids) -> get();

        // Initialize sorting variables with default values
        $sortBy = $request->input('sortBy', '');
        $employee = $request->input('employee', '');
        $application = $request->input('application', '');
        $startDate = $request->input('start_date', '');
        $endDate = $request->input('end_date', '');

        return view('accountant.pendding-transactions', compact('applications', 'employees', 'applications_unique', 'sortBy', 'employee', 'application', 'startDate', 'endDate'));
    }

    public function sort_pending_applications(Request $request) {
        // Initialize the query
        $query = DB::table('served_requests')->where('payment_status', 'Waiting For Review');

        // Initialize variables to hold sorting criteria
        $sortBy = $request->input('sortBy');
        $employee = $request->input('employee');
        $application = $request->input('application');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Apply sorting and filtering based on the selected criteria
        if ($request->filled('sortBy')) {
            switch ($sortBy) {
                case 'date':
                    if ($request->filled(['start_date', 'end_date'])) {
                        $query->whereBetween('served_on', [$startDate, $endDate]);
                    }
                    break;

                case 'employee':
                    if ($request->filled('employee')) {
                        $query->where('assistant', $employee);
                    }
                    break;

                case 'application':
                    if ($request->filled('application')) {
                        $query->where('discipline_identifier', $application);
                    }
                    break;
            }
        }

        // Get filtered transactions
        $pen_transactions = $query -> get();

        // Fetch unique applications for the dropdown
        $applications = DB::table('served_requests') -> where('payment_status', 'Waiting For Review') -> groupBy('discipline_identifier', 'discipline_name') -> get();
        $applications_unique = DB::table('served_requests') -> where('payment_status', 'Waiting For Review') -> groupBy('discipline_identifier', 'discipline_name') -> get();
        $staff_ids = [];
        foreach($applications as $app){
            $staff_ids[] = $app -> assistant;
        }
        $employees = DB::table('staff') -> where('role', '!=', 'Accountant') -> where('role', '!=', 'Admin') -> where('role', '!=', 'Marketing') -> whereIn('id', $staff_ids) -> get();

        // Pass all required variables to the view
        return view('accountant.pendding-transactions', compact('pen_transactions', 'applications', 'employees', 'applications_unique', 'sortBy', 'employee', 'application', 'startDate', 'endDate'));
    }


    public function complete_transactions(Request $request) {

        $sortBy = $request->input('sortBy', '');
        $employee = $request->input('employee', '');
        $application = $request->input('application', '');
        $startDate = $request->input('start_date', '');
        $endDate = $request->input('end_date', '');

        $query = DB::table('served_requests')->where('payment_status', 'Confirmed');

        if ($request->filled('sortBy')) {
            switch ($sortBy) {
                case 'date':
                    if ($request->filled(['start_date', 'end_date'])) {
                        $query->whereBetween('served_on', [$startDate, $endDate]);
                    }
                    break;

                case 'employee':
                    if ($request->filled('employee')) {
                        $query->where('assistant', $employee);
                    }
                    break;

                case 'application':
                    if ($request->filled('application')) {
                        $query->where('discipline_identifier', $application);
                    }
                    break;
            }
        }

        $complete_transactions = $query->get();

        $complete_transactions_unique = DB::table('served_requests') -> where('payment_status', 'Confirmed') -> groupBy('discipline_identifier', 'discipline_name') -> get();

        $staff_ids = [];
        foreach($complete_transactions as $app){
            $staff_ids[] = $app -> assistant;
        }
        $employees = DB::table('staff') -> where('role', '!=', 'Accountant') -> where('role', '!=', 'Admin') -> where('role', '!=', 'Marketing') -> whereIn('id', $staff_ids) -> get();

        return view('accountant.complete-transactions', compact('complete_transactions', 'complete_transactions_unique', 'employees', 'sortBy', 'employee', 'application', 'startDate', 'endDate'));
    }

    public function transaction_review(Request $request) {
        $transaction_info = DB::table('applications') -> where('app_id', $request -> transaction) -> first();
        $applicant_info = DB::table('applicant_info') -> where('id', $request -> applicant) -> first();
        $application_info = DB::table('disciplines') -> where('id', $request -> application) -> first();
        $agent_info = DB::table('staff') -> where('id', $request -> agent) -> first();

        return view('accountant.transaction-review', compact('transaction_info', 'applicant_info', 'application_info', 'agent_info'));
    }

    public function approve_transaction(Request $request) {
        DB::table('applications') -> where('app_id', $request->application_id) -> update(['payment_status' => 'Confirmed']);
        session() -> flash('success', 'Transaction confirmed successfully.');

        return redirect() -> route('pending-transactions');
    }

    public function accountant_deptors(Request $request) {
        $unpaid_applications = DB::table('served_requests') -> where('payment_status', 'Not yet paid') -> orWhere('payment_status', 'Not paid') -> get();

        // Check if the request is for downloading the Excel file
        if ($request->query('download') === 'excel') {
            return Excel::download(new UnpaidApplicationsExport($unpaid_applications), 'unpaid_applications.xlsx');
        }

        return view('accountant.debtors', compact('unpaid_applications'));
    }

    public function getCompleteTransactions()
    {
        $complete_transactions = DB::table('applications')
            ->where('payment_status', 'Confirmed') // Adjust as needed
            ->get();

        return response()->json($complete_transactions); // Return data as JSON
    }

    public function revenue(Request $request) {
        // Fetch your revenue data
        $app_incomes = DB::table('served_requests')
            ->where('payment_status', 'Paid')
            ->where('application_status', 'Complete')
            ->get();

        $todayApps = DB::table('served_requests')
            ->where('payment_status', 'Paid')
            ->where('application_status', 'Complete')
            ->whereDate('served_on', Carbon::today())
            ->get();

        $todayAds = DB::table('adverts')
            ->whereDate('posted_on', Carbon::today())
            ->get();

        $ads = DB::table('adverts')
            ->where('status', 'active')
            ->get();

        // Check if the request is for downloading the Excel file
        if ($request->query('download') === 'excel') {
            return Excel::download(new RevenueExport($app_incomes), 'business_revenues.xlsx');
        }

        // Return the view with the data
        return view('admin.revenue', compact('app_incomes', 'ads', 'todayApps', 'todayAds'));
    }

    public function remind_debtor(Request $request)
    {
        try {
            $unpaid_applications = DB::table('served_requests')->where('application_id', $request->transaction)->first();
            $encryptedApplicationId = Crypt::encryptString($unpaid_applications->application_id);

            $url = route('app-payment', [
                'discipline' => $unpaid_applications->discipline,
                'client' => $unpaid_applications->names,
                'client_phone' => $unpaid_applications->phone_number,
                'application_id' => $encryptedApplicationId,
            ]);

            $app = $unpaid_applications->discipline_name;
            $client = $unpaid_applications->names;

            Mail::to($unpaid_applications->email)->send(new Remind($url, $app, $client));

            // $smsNotification = new Notifications();
            // $utils = new Utils();

            // // Send SMS notification
            // $smsData = [
            //     'key' => $smsNotification->getSmsApiKey(),
            //     'message' => 'Dear ' . $client . ', You have not yet paid for ' . $unpaid_applications->discipline_name .' has been successfully received by BScholarz, Thank you for choosing BScholarz. We look forward to working with you again.',
            //     'recipients' => [
            //         $request_info->user->phone_number
            //     ]
            // ];

            // $smsNotification->sendSms($smsData);

            // Flash success message
            session()->flash('success', 'A reminder email has been sent successfully!');

            return redirect()->route('accountant-deptors');
        } catch (\Exception $e) {
            \Log::error('Email send error: ' . $e->getMessage());

            // Flash error message
            session()->flash('error', 'Failed to send reminder email.');

            return redirect()->route('accountant-deptors');
        }
    }

    public function sendClarificationMessage(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'agent_id' => 'required|exists:staff,id',
            'application_id' => 'required|exists:served_requests,application_id',
        ]);

        if(DB::table('applications') -> where('app_id', $request->input('application_id')) -> update(['payment_status' => 'Agent Needs To Clarify'])) {
            $message = Message::create([
                'issue' => $request->input('title'),
                'sender' => 25,
                'receiver' => $request->input('agent_id'),
                'app' => $request->input('application_id'),
                'request' => $request->input('desc'),
                'account' => "Accountant",
                'status' => 'pending',
                ]);
            }

        session() -> flash('success', 'A clarification request has been sent to the agent! this transaction will now be found on your dashboard, under "Waiting for clarificarion"');
        return redirect() -> route('pending-transactions');
    }


}
