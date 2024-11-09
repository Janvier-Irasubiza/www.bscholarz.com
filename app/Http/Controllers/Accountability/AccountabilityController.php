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
use Illuminate\Support\Facades\Cache;
use App\Exports\TransactionsExport;
use App\Exports\UnpaidApplicationsExport;
use App\Exports\RevenueExport;
use Maatwebsite\Excel\Facades\Excel;

class AccountabilityController extends Controller {
    public function accountant_dashboard() {
        return view('accountant.dashboard');
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
        $unpaid_applications = DB::table('served_requests')
            ->where('payment_status', 'Not yet paid')
            ->orWhere('payment_status', 'Not paid')
            ->get();

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

    public function remind_debtor() {
        
    }

}
