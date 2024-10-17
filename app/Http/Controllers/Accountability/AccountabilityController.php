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

class AccountabilityController extends Controller {
    public function accountant_dashboard() {
        return view('accountant.dashboard');
    }

    public function pending_transactions() {
        $pen_transactions = DB::table('applications') -> where('payment_status', 'Waiting For Review') -> get();

        foreach ($pen_transactions as $transaction) {
            $assistant = DB::table('staff') -> where('id', $transaction -> assistant)->first();

            if ($assistant) {
                $transaction->assistant_names = $assistant->names;
                $transaction->assistant_email = $assistant->email;
            }
            else {
                $transaction->assistant_name = 'N/A';
                $transaction->assistant_email = 'N/A';
            }
        }

        return view('accountant.pendding-transactions', compact('pen_transactions'));
    }

    public function complete_transactions() {
        $complete_transactions = DB::table('applications') -> where('payment_status', 'Confirmed') -> get();

        foreach ($complete_transactions as $transaction) {
            $assistant = DB::table('staff') -> where('id', $transaction -> assistant)->first();

            if ($assistant) {
                $transaction->assistant_names = $assistant->names;
                $transaction->assistant_email = $assistant->email;
            }
            else {
                $transaction->assistant_name = 'N/A';
                $transaction->assistant_email = 'N/A';
            }
        }

        return view('accountant.complete-transactions', compact('complete_transactions'));
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

        return redirect() -> route('dashboard');
    }

    public function accountant_deptors() {
        $unpaid_applications = DB::table('applications') -> where('payment_status', 'Not yet paid') -> get();

        foreach ($unpaid_applications as $application) {
            $deptor = DB::table('applicant_info')->where('id', $application->applicant)->first();

            $discipline = DB::table('disciplines')->where('id', $application->discipline_id)->first();

            if ($deptor) {
                $application->deptor_names = $deptor->names;
                $application->deptor_email = $deptor->email;
                $application->deptor_phone = $deptor->phone_number;
            } else {
                $application->deptor_names = 'N/A';
                $application->deptor_email = 'N/A';
                $application->deptor_phone = 'N/A';
            }

            if ($discipline) {
                $application->application_name = $discipline->discipline_name;
                $application->application_org = $discipline->organization;
            } else {
                $application->application_name = 'N/A';
                $application->application_org = 'N/A';
            }
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
}
