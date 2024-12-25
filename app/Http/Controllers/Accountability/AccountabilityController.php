<?php

namespace App\Http\Controllers\Accountability;

use App\Exports\RevenueExport;
use App\Exports\UnpaidApplicationsExport;
use App\Http\Controllers\Controller;
use App\Mail\Remind;
use App\Models\Message;
use App\Models\MessageReply;
use App\Models\Payment;
use App\Models\Request as Applications;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use Mail;

class AccountabilityController extends Controller
{
    public function accountant_dashboard(Request $request)
    {
        $payments = Payment::whereHas('application', function ($query) {
            $query->where('payment_status', 'Agent Needs To Clarify');
        })->with(['customer', 'application'])->get();

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

        $clarifications_unique = DB::table('served_requests')
            ->select('discipline_identifier', 'discipline_name', DB::raw('MIN(id) as id')) // Aggregate non-grouped columns
            ->where('payment_status', 'Agent Needs To Clarify')
            ->groupBy('discipline_identifier', 'discipline_name')
            ->get();

        $staff_ids = [];
        foreach ($payments as $payment) {
            if ($payment->application) { // Check if the relationship exists
                $staff_ids[] = $payment->application->assistant;
            }
        }
        $employees = DB::table('staff')->where('role', '!=', 'Accountant')->where('role', '!=', 'Admin')->where('role', '!=', 'Marketing')->whereIn('id', $staff_ids)->get();

        // Initialize sorting variables with default values
        $sortBy = $request->input('sortBy', '');
        $employee = $request->input('employee', '');
        $application = $request->input('application', '');
        $startDate = $request->input('start_date', '');
        $endDate = $request->input('end_date', '');

        return view('accountant.dashboard', compact('total_revenues', 'today_revenues', 'this_week_revenues', 'total_requests', 'today_requests', 'this_week_requests', 'total_services', 'ready_services', 'upcoming_services', 'clarifications_unique', 'employees', 'sortBy', 'employee', 'application', 'startDate', 'endDate', 'payments'));
    }

    public function pending_transactions(Request $request)
    {
        $payments = Payment::whereHas('application', function ($query) {
            $query->where('payment_status', 'Waiting For Review');
        })->with(['customer', 'application'])->get();

        // Initialize staff_ids array
        $staff_ids = [];

        // Loop through the $applications array to get staff IDs
        foreach ($payments as $payment) {
            if ($payment->application) { // Check if the relationship exists
                $staff_ids[] = $payment->application->assistant;
            }
        }

        // Fetch employees who are not Accountants, Admins, or Marketers, and whose IDs are in the staff_ids array
        $employees = DB::table('staff')
            ->whereNotIn('role', ['Accountant', 'Admin', 'Marketing'])
            ->whereIn('id', $staff_ids)
            ->get();

        // Initialize sorting variables with default values
        $sortBy = $request->input('sortBy', '');
        $employee = $request->input('employee', '');
        $application = $request->input('application', '');
        $startDate = $request->input('start_date', '');
        $endDate = $request->input('end_date', '');

        // Return the view with the necessary data
        return view('accountant.pendding-transactions', compact(
            'payments',
            'employees',
            'sortBy',
            'employee',
            'application',
            'startDate',
            'endDate'
        ));

    }

    public function sort_pending_applications(Request $request)
    {
        // Initialize the query
        $query = Payment::whereHas('application', function ($query) {
            $query->where('payment_status', 'Waiting For Review');
        })->with(['customer', 'application'])
            ->get();

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
        $pen_transactions = $query;

        // Fetch unique applications for the dropdown
        $applications = $query->groupBy(function ($item) {
            return $item->application->discipline_identifier;
        });

        $applications_unique = $query->pluck('application')->unique('discipline_identifier');

        $staff_ids = [];
        foreach ($applications as $group) { // Each group is a collection of items
            foreach ($group as $app) { // Iterate through individual items in the group
                $staff_ids[] = $app->application->assistant;
            }
        }
        $employees = DB::table('staff')->where('role', '!=', 'Accountant')->where('role', '!=', 'Admin')->where('role', '!=', 'Marketing')->whereIn('id', $staff_ids)->get();

        // Pass all required variables to the view
        return view('accountant.pendding-transactions', compact('pen_transactions', 'applications', 'employees', 'applications_unique', 'sortBy', 'employee', 'application', 'startDate', 'endDate'));
    }

    public function complete_transactions(Request $request)
    {

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

        $complete_transactions_unique = DB::table('served_requests')
        ->select('discipline_identifier', 'discipline_name', DB::raw('MIN(id) as id')) // Add an aggregated column
        ->where('payment_status', 'Confirmed')
        ->groupBy('discipline_identifier', 'discipline_name')
        ->get();

        $staff_ids = [];
        foreach ($complete_transactions as $app) {
            $staff_ids[] = $app->assistant;
        }
        $employees = DB::table('staff')->where('role', '!=', 'Accountant')->where('role', '!=', 'Admin')->where('role', '!=', 'Marketing')->whereIn('id', $staff_ids)->get();

        $payments = Payment::whereHas('application', function ($query) {
            $query->where('payment_status', 'Confirmed');
        })->with(['customer', 'application'])->get();

        return view('accountant.complete-transactions', compact('complete_transactions', 'complete_transactions_unique', 'employees', 'sortBy', 'employee', 'application', 'startDate', 'endDate', 'payments'));
    }

    public function transaction_review(Request $request)
    {
        $payments = Payment::with(['customer', 'application'])
            ->where('id', $request->transaction)
            ->first();

        $transaction_info = DB::table('applications')->where('app_id', $request->transaction)->first();
        $applicant_info = DB::table('applicant_info')->where('id', $request->applicant)->first();
        $application_info = DB::table('disciplines')->where('id', $request->application)->first();
        $agent_info = DB::table('staff')->where('id', $request->agent)->first();

        return view('accountant.transaction-review', compact('transaction_info', 'applicant_info', 'application_info', 'agent_info', 'payments'));
    }

    public function approve_transaction(Request $request)
    {
        $payment = Payment::find($request->transaction);
        $application = Applications::find($payment->application->app_id);

        if ($application->payment_status == 'Waiting For Review') {
            $application->payment_status = 'Confirmed';
            $application->save();

            $payment->status = 'Confirmed';
            $payment->save();
        } elseif ($application->payment_status == 'Partial Payment Waiting For Review') {
            $application->payment_status = 'Partial Payment Confirmed';
            $application->save();

            $payment->status = 'Confirmed';
            $payment->save();
        } elseif ($application->payment_status == 'Agent Needs To Clarify' && $application->outstanding_payment_status == 'Partial payment') {
            $application->payment_status = 'Partial Payment Confirmed';
            $application->save();

            $payment->status = 'Confirmed';
            $payment->save();
        } else {
            $application->payment_status = 'Confirmed';
            $application->save();

            $payment->status = 'Confirmed';
            $payment->save();
        }

        session()->flash('success', 'Transaction was approved successfully.');

        return redirect()->route('pending-transactions');
    }

    public function accountant_deptors(Request $request)
    {
        $unpaid_applications = DB::table('served_requests')->whereNull('deliberation')->orWhere('deliberation', 'Refused to pay')->orderBy('served_on', 'desc')->get();
        $reminded_debtors = DB::table('served_requests')->where('deliberation', 'Reminded')->get();

        // Check if the request is for downloading the Excel file
        if ($request->query('download') === 'excel') {
            return Excel::download(new UnpaidApplicationsExport($unpaid_applications), 'unpaid_applications.xlsx');
        }

        return view('accountant.debtors', compact('unpaid_applications', 'reminded_debtors'));
    }

    public function getCompleteTransactions()
    {
        $complete_transactions = DB::table('applications')
            ->where('payment_status', 'Confirmed') // Adjust as needed
            ->get();

        return response()->json($complete_transactions); // Return data as JSON
    }

    public function revenue(Request $request)
    {
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

            if (!$unpaid_applications) {
                session()->flash('error', 'The application could not be found.');
                return redirect()->route('accountant-deptors');
            }

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

            DB::table('served_requests')
                ->where('application_id', $request->transaction)
                ->update(['deliberation' => 'Reminded']);

            session()->flash('success', 'A reminder email has been sent successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to send reminder email or update database: ' . $e->getMessage());

            session()->flash('error', 'Failed to send reminder email. Please try again later.');
        }

        return redirect()->route('accountant-deptors');
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

        $app = Applications::find($request->input('application_id'));
        $payment = Payment::find($request->transaction);
        if ($app) {
            $app->payment_status = 'Agent Needs To Clarify';
            $app->save();

            $payment->status = 'Agent Needs To Clarify';
            $payment->save();
        }

        $message = Message::create([
            'issue' => $request->input('title'),
            'sender' => auth('staff')->user()->id,
            'receiver' => $request->input('agent_id'),
            'app' => $request->input('application_id'),
            'request' => $request->input('desc'),
            'account' => "Accountant",
            'status' => 'pending',
        ]);

        MessageReply::create([
            'message_id' => $message->id,
            'reply' => $request->input('desc'),
            'user_id' => auth('staff')->user()->id,
        ]);

        session()->flash('success', 'A clarification request has been sent to the agent! this transaction will now be found on your dashboard, under "Waiting for clarificarion"');
        return redirect()->route('pending-transactions');
    }

}
