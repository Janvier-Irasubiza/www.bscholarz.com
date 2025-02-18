<?php

namespace App\Http\Controllers\Staff;

// use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Notifications;
use App\Http\Controllers\Utils;
use App\Mail\CompletedApp;
use App\Mail\PaymentReceived;
use App\Mail\Postpone;
use App\Mail\RequestToPay;
use App\Mail\Unreachable;
use App\Models\Applicant_info;
use App\Models\Payment;
use App\Models\Request as Applications;
use Carbon\Carbon;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Mail;
use Redirect;
use Session;

class StaffController extends Controller
{

    public function staff_dashboard()
    {
        $my_applications = DB::table('served_requests')->where('assistant', Auth::guard('staff')->user()->id)->count();
        $my_funds = DB::table('applications')
            ->select(DB::raw('sum(assistant_pending_commission) as commission'))
            ->where('assistant', Auth::guard('staff')->user()->id)
            ->where('remittance_status', 'on hold')
            ->where('payment_status', 'Confirmed')
            ->orWhere('payment_status', 'Partial Payment Confirmed')
            ->first();

        $postponed_applications = DB::table('applications')
            ->where('assistant', Auth::guard('staff')->user()->id)
            ->where('status', 'Postponed')
            ->WhereNull('deletion_status')
            ->get();

        // $ready_clients = DB::table('user_requests')->where('status', 'Pending')->whereNull('deletion_status')->where('due_date', '>', now()->format('Y-m-d H:i:s.u'))->get();
        $ready_clients = Applications::with('discipline')
            ->with('user')
            ->with('appAssistant')
            ->where('status', 'Pending')
            ->where('request_service_paid', true)
            ->whereNull('deletion_status')
            ->whereHas('discipline', function ($query) {
                $query->where('due_date', '>=', now()->format('Y-m-d H:i:s.u'));
            })
            ->get();

        $outstanding_clients = DB::table('served_requests')
            ->join('applications', 'served_requests.application_id', '=', 'applications.app_id')
            ->where('served_requests.assistant', Auth::guard('staff')->user()->id)
            ->where('served_requests.amount_not_paid', 0)
            ->whereNotNull('served_requests.outstanding_amount')
            ->whereNull('served_requests.deliberation')
            ->select('served_requests.*', 'applications.poked')
            ->get();

        $under_review = DB::table('user_requests')->where('status', '<>', 'Pending')->where('status', '<>', 'Complete')->where('status', '<>', 'Postponed')->WhereNull('deletion_status')->where('revied_by', Auth::guard('staff')->user()->id)->where('due_date', '>', now()->format('Y-m-d H:i:s.u'))->get();
        //$under_review = DB::table('user_requests') -> where('status', '<>', 'Pending') -> where('status', '<>', 'Complete') -> where('status', '<>', 'Postponed') -> where('deletion_status', '<>', 'Requested') -> where('deletion_status', '<>', 'Deletion Confirmed') -> where('revied_by', Auth::guard('staff') -> user() -> id) -> get();
        $user_info = DB::table('staff')
            ->where('id', Auth::guard('staff')->user()->id)
            ->first();

        $balance = DB::table('served_requests')
            ->where('assistant', Auth::guard('staff')
            ->user()->id)->where('application_status', 'Complete')
            ->where('payment_status', 'Confirmed')
            ->orWhere('payment_status', 'Partial Payment Confirmed')
            ->get();
        $active_emp = DB::table('staff')->select(DB::raw('count(id) as active'))->where('status', 'Online')->where('id', '<>', Auth::guard('staff')->user()->id)->first();

        return view('staff.staff-dashboard', compact('my_applications', 'my_funds', 'postponed_applications', 'ready_clients', 'outstanding_clients', 'active_emp', 'balance', 'under_review', 'user_info'));
    }

    public function customer_details(Request $request)
    {

        date_default_timezone_set('Africa/Kigali');

        $client_info = DB::table('applicant_info')->where('id', $request->customer_info)->first();
        $client_background = DB::table('applicant_education_info')->where('applicant', $request->customer_info)->get();
        $client_docs = DB::table('applicant_documents')->where('applicant', $request->customer_info)->get();
        $application_requested = DB::table('user_requests')->where('application_id', $request->application_info)->where('id', $request->customer_info)->first();
        $applications_items = DB::table('applications')->where('app_id', $request->application_info)->where('applicant', $request->customer_info)->first();
        $all_details = DB::table('served_requests')->where('id', $request->customer_info)->where('amount_not_paid', '<>', 0)->where('deliberation', 'Refused to pay')->get();

        DB::table('applications')->where('app_id', $request->application_info)->limit(1)->update(['status' => 'Under Review', 'revied_by' => Auth::guard('staff')->user()->id, 'revied_on' => date('Y-m-d H:m:s'), 'review_ccl' => 'yes']);

        $under_review = DB::table('user_requests')->where('status', 'Under Review')->where('revied_by', Auth::guard('staff')->user()->id)->get();

        $outs = DB::table('served_requests')->where('id', $request->customer_info)->where('outstanding_amount', '<>', 0)->get();

        return view('staff.customer-details', compact(
            'client_info',
            'client_background',
            'client_docs',
            'application_requested',
            'applications_items',
            'all_details',
            'under_review',
            'outs'
        ));
    }

    public function changeClientPasswordForm(Request $request)
    {
        $client = Applicant_info::find($request->customer_info);
        $application = Applications::find($request->application_info);
        return view('staff.client-password-change', compact('client', 'application'));
    }

    public function updateClientPassword(Request $request)
    {
        $this->validate($request, [
            'client_id' => 'required|exists:applicant_info,id',
            'application_id' => 'required|exists:applications,app_id',
            'new_password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $client = Applicant_info::find($request->client_id);
        $client->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('customer-details', ['customer_info' => $request->client_id, 'application_info' => $request->application_id])->with('success', 'Password changed successfully');

    }

    public function record_activity()
    {
        $disciplines = DB::table('disciplines')->where('category', '<>', 'Custom')->where('due_date', '>', now()->format('Y-m-d H:i:s.u'))->get();

        return view('staff.record-activity', compact('disciplines'));
    }

    public function record_new_activity(Request $request)
    {
        $record = DB::table('applicant_info')->where('email', $request->consumerEmail)->first();
        $partners = DB::table('rhythmbox')->get();

        if ($record) {
            Session::put('email_error', $record->names);
            Session::put('applicant', $record->id);
            return Redirect::back()->withInput($request->all());
        }

        $request->validate([
            'activityName' => 'required',
            'consumerNames' => 'required',
            'consumerEmail' => 'required',
            'consumerPhoneNumber' => 'required',
            'serviceCost' => 'required',
            'paymentStatus' => 'required',
        ]);

        $userId = Applicant_info::create([
            'names' => $request->consumerNames,
            'email' => $request->consumerEmail,
            'phone_number' => $request->consumerPhoneNumber,
        ]);

        $activityApplicationInfo = [];
        $paidAmount = 0;

        if (!empty($request->customActivityName)) {
            $newDiscipline = $this->createNewDiscipline($request);
            $paidAmount = $this->processPayment($request, $newDiscipline->service_fee, $partners, $activityApplicationInfo, $userId);
        } else {
            $existingDiscipline = DB::table('disciplines')->where('id', $request->activityName)->first();
            $paidAmount = $this->processPayment($request, $request->serviceCost, $partners, $activityApplicationInfo, $userId, $existingDiscipline->id);
        }

        $newApplicationId = DB::table('applications')->insertGetId($activityApplicationInfo);

        if ($paidAmount > 0) {
            Payment::create([
                'applicant_id' => $userId->id,
                'application_id' => $newApplicationId,
                'amount' => $paidAmount,
                'status' => 'Waiting For Review',
            ]);
        }

        return redirect()->route('staff-dashboard');
    }

    private function createNewDiscipline($request)
    {
        do {
            $identifier = substr(str_shuffle('qazxswedcvfrtgbnhyujmkiolp0123456789'), 0, 8);
        } while (DB::table('disciplines')->where('identifier', $identifier)->exists());

        DB::table('disciplines')->insert([
            'identifier' => $identifier,
            'discipline_name' => $request->customActivityName,
            'service_fee' => $request->serviceCost,
            'status' => 'N/A',
        ]);

        return DB::table('disciplines')->where('identifier', $identifier)->first();
    }

    private function processPayment($request, $serviceFee, $partners, &$activityApplicationInfo, $userId, $app)
    {
        $paidAmount = 0;
        $commission = 0;

        if ($request->paymentStatus === 'Paid') {
            $paidAmount = $serviceFee;
        } elseif ($request->paymentStatus === 'Partial-payment') {
            $paidAmount = $request->receivedAmount ?? 0;
        }

        $commission = $this->calculateCommission($paidAmount, $partners, $serviceFee);

        $outstandingAmount = $serviceFee - $paidAmount;

        $this->buildActivityInfo($activityApplicationInfo, $userId, $request, $serviceFee, $paidAmount, $commission, $outstandingAmount, $app);

        return $paidAmount;
    }

    private function calculateCommission($paidAmount, $partners, $serviceFee)
    {
        foreach ($partners as $partner) {
            $partnerShare = ($paidAmount * $partner->percentage) / 100;
            DB::table('rhythmbox')->where('id', $partner->id)->increment('pending_amount', $partnerShare);
        }

        return ($paidAmount * Auth::guard('staff')->user()->percentage) / 100;
    }

    private function buildActivityInfo(&$activityApplicationInfo, $userId, $request, $serviceFee, $paidAmount, $commission, $outstandingAmount = 0, $discipline)
    {
        $activityApplicationInfo = [
            'applicant' => $userId->id,
            'discipline_id' => $discipline,
            'payment_status' => 'Waiting For Review',
            'amount_paid' => $paidAmount,
            'outstanding_amount' => $outstandingAmount,
            'payment_date' => now(),
            'status' => 'Complete',
            'assistant' => Auth::guard('staff')->user()->id,
            'application_type' => !empty($request->customActivityName) ? 'Custom' : 'Standard',
            'served_on' => now(),
            'observation' => $request->desc,
            'assistant_pending_commission' => $commission,
        ];
    }

    public function add_client_app(Request $request)
    {

        $partners = DB::table('rhythmbox')->get();

        $validateData = $request->validate([
            'activityName' => ['required'],
            'consumerNames' => ['required'],
            'consumerEmail' => ['required'],
            'consumerPhoneNumber' => ['required'],
            'serviceCost' => ['required'],
            'paymentStatus' => ['required'],
        ]);

        $activity_application_info = [];

        if (!empty($request->customActivityName)) {

            function identifierGen()
            {
                return substr(str_shuffle('qazxswedcvfrtgbnhyujmkiolp0123456789'), 0, 8);
            }

            getId:
            $identifier = identifierGen();

            if (DB::table('disciplines')->where('identifier', $identifier)->first()) {
                goto getId;
            }

            $new_discipline = [
                'identifier' => $identifier,
                'discipline_name' => $request->customActivityName,
                'service_fee' => $request->serviceCost,
                'status' => 'N/A',
            ];

            DB::table('disciplines')->insert($new_discipline);
            $new_id = DB::table('disciplines')->where('identifier', $identifier)->first();

            if ($request->paymentStatus == 'Paid') {

                foreach ($partners as $partner) {

                    $percentage = $partner->pending_amount + (($request->serviceCost * $partner->percentage) / 100);

                    DB::table('rhythmbox')->limit(1)->where('id', $partner->id)->update(['pending_amount' => $percentage]);

                }

                $commision = ($new_id->service_fee * Auth::guard('staff')->user()->percentage) / 100;

                array_push($activity_application_info, [
                    'applicant' => $request->applicant_id,
                    'discipline_id' => $new_id->id,
                    'payment_status' => $request->paymentStatus,
                    'amount_paid' => $new_id->service_fee,
                    'payment_date' => date('Y-m-d H:i:s'),
                    'status' => 'Complete',
                    'assistant' => Auth::guard('staff')->user()->id,
                    'application_type' => 'Custom',
                    'served_on' => date('Y-m-d H:i:s'),
                    'observation' => $request->desc,
                    'assistant_pending_commission' => $commision,
                ]);
            } elseif ($request->paymentStatus == 'Partial-payment') {

                foreach ($partners as $partner) {

                    $percentage = $partner->pending_amount + (($request->receivedAmount * $partner->percentage) / 100);

                    DB::table('rhythmbox')->limit(1)->where('id', $partner->id)->update(['pending_amount' => $percentage]);

                }

                $commision = ($request->receivedAmount * Auth::guard('staff')->user()->percentage) / 100;

                array_push($activity_application_info, [
                    'applicant' => $request->applicant_id,
                    'discipline_id' => $new_id->id,
                    'payment_status' => 'Paid',
                    'amount_paid' => $request->receivedAmount,
                    'outstanding_amount' => $request->serviceCost - $request->receivedAmount,
                    'payment_date' => date('Y-m-d H:i:s'),
                    'status' => 'Complete',
                    'assistant' => Auth::guard('staff')->user()->id,
                    'application_type' => 'Custom',
                    'served_on' => date('Y-m-d H:i:s'),
                    'observation' => $request->desc,
                    'assistant_pending_commission' => $commision,
                ]);

            } else {
                array_push($activity_application_info, [
                    'applicant' => $request->applicant_id,
                    'discipline_id' => $new_id->id,
                    'payment_status' => $request->paymentStatus,
                    'outstanding_amount' => $request->serviceCost,
                    'payment_date' => date('Y-m-d H:i:s'),
                    'status' => 'Complete',
                    'assistant' => Auth::guard('staff')->user()->id,
                    'application_type' => 'Custom',
                    'served_on' => date('Y-m-d H:i:s'),
                    'observation' => $request->desc,
                ]);
            }

            DB::table('applications')->insert($activity_application_info);

        }

        if (empty($request->customActivityName)) {

            if ($request->paymentStatus == 'Paid') {

                // $fee = DB::table('disciplines') -> where('id', $request -> activityName) -> select('service_fee') -> first();

                foreach ($partners as $partner) {

                    $percentage = $partner->pending_amount + (($request->serviceCost * $partner->percentage) / 100);

                    DB::table('rhythmbox')->limit(1)->where('id', $partner->id)->update(['pending_amount' => $percentage]);

                }

                $commision = ($request->serviceCost * Auth::guard('staff')->user()->percentage) / 100;

                array_push($activity_application_info, [
                    'applicant' => $request->applicant_id,
                    'discipline_id' => $request->activityName,
                    'payment_status' => $request->paymentStatus,
                    'amount_paid' => $request->serviceCost,
                    'payment_date' => date('Y-m-d H:i:s'),
                    'status' => 'Complete',
                    'assistant' => Auth::guard('staff')->user()->id,
                    'application_type' => 'Custom',
                    'served_on' => date('Y-m-d H:i:s'),
                    'observation' => $request->desc,
                    'assistant_pending_commission' => $commision,
                ]);
            } elseif ($request->paymentStatus == 'Partial-payment') {

                foreach ($partners as $partner) {

                    $percentage = $partner->pending_amount + (($request->receivedAmount * $partner->percentage) / 100);

                    DB::table('rhythmbox')->limit(1)->where('id', $partner->id)->update(['pending_amount' => $percentage]);

                }

                $app_req = DB::table('disciplines')->where('id', $request->activityName)->first();

                $commision = ($request->receivedAmount * Auth::guard('staff')->user()->percentage) / 100;

                array_push($activity_application_info, [
                    'applicant' => $request->applicant_id,
                    'discipline_id' => $app_req->id,
                    'payment_status' => 'Paid',
                    'amount_paid' => $request->receivedAmount,
                    'outstanding_amount' => $request->serviceCost - $request->receivedAmount,
                    'payment_date' => date('Y-m-d H:i:s'),
                    'status' => 'Complete',
                    'assistant' => Auth::guard('staff')->user()->id,
                    'application_type' => 'Custom',
                    'served_on' => date('Y-m-d H:i:s'),
                    'observation' => $request->desc,
                    'assistant_pending_commission' => $commision,
                ]);

            } else {

                $app_req = DB::table('disciplines')->where('id', $request->activityName)->first();

                array_push($activity_application_info, [
                    'applicant' => $request->applicant_id,
                    'discipline_id' => $request->activityName,
                    'payment_status' => $request->paymentStatus,
                    'outstanding_amount' => $request->serviceCost,
                    'payment_date' => date('Y-m-d H:i:s'),
                    'status' => 'Complete',
                    'assistant' => Auth::guard('staff')->user()->id,
                    'application_type' => 'Custom',
                    'served_on' => date('Y-m-d H:i:s'),
                    'observation' => $request->desc,
                ]);
            }

            DB::table('applications')->insert($activity_application_info);
        }

        return redirect()->route('staff-dashboard');
    }

    public function mark_application_as_complete(Request $request)
    {
        $this->validate($request, [
            'amount_to_be_paid' => 'required|numeric',
        ]);

        $outstanding_amount = DB::table('user_requests')->where('application_id', $request->application_id)->first();

        if (DB::table('applications')->limit(1)->where('app_id', $request->application_id)->update(['status' => 'Complete', 'outstanding_amount' => $request->amount_to_be_paid, 'served_on' => date('Y-m-d H:i:s')])) {

            // Mail
            $url = url(route('app-payment', [
                'discipline' => $outstanding_amount->discipline_identifier,
                'rq' => $outstanding_amount->application_id,
                'clt' => $outstanding_amount->id,
            ]), false);

            $app = $outstanding_amount->discipline_name;
            $client = $outstanding_amount->names;

            Mail::to($outstanding_amount->email)->send(new CompletedApp($url, $client, $app));

            /*
            $phone = $outstanding_amount -> phone_number;

            if (substr(preg_replace('/[^0-9]/', '', $phone),0,4)=='2507' && strlen($phone)==12) {
            $phone = $phone;
            $rightphone = true;
            }
            else {
            if (substr(preg_replace('/[^0-9]/', '', $phone),0,2)=='07' && strlen($phone)==10) {
            $phone = '25'.$phone;
            $rightphone = true;
            }
            else {
            $rightphone = false;
            }
            }

            $uid = time().''.rand(100,999).''.rand(1000,9999);
            $returl = url(route('sms-callback'));

            //SMS
            $params = [
            'ohereza' => 'BSholarz',
            'kuri' => $phone,
            'ubutumwa' => urlencode('Your request for '. $app . ' has been processed successfully. Kindly, you are required to pay for the service by clicking this link: ' . $url),
            'client' => 'alexish',
            'password' => '0v4h5g8y9h7w',
            'msgid' => $uid,
            'receivedlr' => 'yes',
            'callurl' => $returl,
            'retype' => 'PLAIN',
            ];

            $apiUrl = 'https://api.sms.rw/';

            // Initialize cURL session
            $ch = curl_init();

            // Set cURL options
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Execute cURL session
            $response = curl_exec($ch);

            // Close cURL session
            curl_close($ch);

            // Process the response
            // return $response; // This might contain a success or error message from the API

             */

            return redirect()->route('staff-dashboard');

        }

        /* $percentage = DB::table('staff') -> where('id', Auth::guard('staff') -> user() -> id) -> select('percentage') -> first();
        $my_percentage = ((intval($amount -> amount_paid) * $percentage -> percentage)/100);

        $partners = DB::table('rhythmbox') -> get();

        foreach ($partners as $partner) {

        $percentage = $partner -> pending_amount + (($amount -> amount_paid * $partner -> percentage) / 100);

        DB::table('rhythmbox') -> limit(1) -> where('id', $partner -> id) -> update(['pending_amount' => $percentage]);

        } */else {

            return back();

        }
    }

    public function delete_request(Request $request)
    {

        DB::table('applications')->where('app_id', $request->application_id)->update(['deletion_status' => 'Requested']);

        session()->flash('delete_success', 'Application deleted successfully.');

        return redirect()->route('staff-dashboard');
    }

    public function unreachable(Request $request)
    {

        $client_data = DB::table('applicant_info')->where('id', $request->applicant)->first();
        $client = $client_data->names;
        $mail_to = $client_data->email;

        DB::table('applications')->where('app_id', $request->application_id)->update(['review_ccl' => 'Phone Unreachable']);
        Mail::to($mail_to)->send(new Unreachable($client));

        return redirect()->route('staff-dashboard');
    }

    public function begin_application(Request $request)
    {
        $app_link = DB::table('user_requests')->where('application_id', $request->application_info)->select('link')->first();
        DB::table('applications')->where('app_id', $request->application_info)->update(['status' => 'In Progress', 'assistant' => Auth::guard('staff')->user()->id]);

        return redirect()->away($app_link->link);
    }

    public function postponed_data(Request $request)
    {
        $validateData = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
            'link' => ['required'],
            'reason' => ['required'],
        ]);

        $postponed_application_data = [
            'username' => $request->username,
            'password' => $request->password,
            'link_to_dashboard' => $request->link,
            'postponing_reason' => $request->reason,
            'status' => 'Postponed',
            'assistant' => Auth::guard('staff')->user()->id,
        ];

        if (DB::table('applications')->where('app_id', $request->application_id)->update($postponed_application_data)) {

            $app_info = DB::table('applications')->where('app_id', $request->application_id)->first();
            $client_info = DB::table('applicant_info')->where('id', $app_info->applicant)->first();
            $discipline_info = DB::table('disciplines')->where('id', $app_info->discipline_id)->first();

            $url = url(route('client-profile'));
            $app = $discipline_info->discipline_name;
            $reason = $request->reason;
            $client = $client_info->names;

            Mail::to($client_info->email)->send(new Postpone($url, $client, $app, $reason));

            return redirect()->route('staff-dashboard');

        } else {

            return back();

        }

    }

    public function resume_application(Request $request)
    {
        DB::table('applications')->where('app_id', $request->application_info)->where('applicant', $request->customer_info)->where('assistant', Auth::guard('staff')->user()->id)->update(['status' => 'In Progress']);

        $client_info = DB::table('applicant_info')->where('id', $request->customer_info)->first();
        $client_background = DB::table('applicant_education_info')->where('applicant', $request->customer_info)->get();
        $client_docs = DB::table('applicant_documents')->where('applicant', $request->customer_info)->get();
        $application_requested = DB::table('user_requests')->where('application_id', $request->application_info)->where('id', $request->customer_info)->first();
        $applications_items = DB::table('applications')->where('app_id', $request->application_info)->where('applicant', $request->customer_info)->first();
        $all_details = DB::table('served_requests')->where('id', $request->customer_info)->where('amount_not_paid', '<>', 0)->where('deliberation', 'Refused to pay')->get();

        return view('staff.customer-details', compact('client_info', 'client_background', 'client_docs', 'application_requested', 'applications_items', 'all_details'));
    }

    public function reconsider_application(Request $request)
    {
        $client_info = DB::table('applicant_info')->where('id', $request->customer_info)->first();
        $client_background = DB::table('applicant_education_info')->where('applicant', $request->customer_info)->get();
        $client_docs = DB::table('applicant_documents')->where('applicant', $request->customer_info)->get();
        $application_requested = DB::table('user_requests')->where('application_id', $request->application_info)->where('id', $request->customer_info)->first();
        $applications_items = DB::table('applications')->where('app_id', $request->application_info)->where('applicant', $request->customer_info)->first();
        $all_details = DB::table('served_requests')->where('id', $request->customer_info)->where('amount_not_paid', '<>', 0)->where('deliberation', 'Refused to pay')->get();
        $outs = DB::table('served_requests')->where('id', $request->customer_info)->where('outstanding_amount', '<>', 0)->get();

        return view('staff.customer-details', compact('client_info', 'client_background', 'client_docs', 'application_requested', 'applications_items', 'all_details', 'outs'));
    }

    public function resume_postponed_application(Request $request)
    {
        $app_link = DB::table('applications')->where('app_id', $request->application_info)->select('link_to_dashboard')->first();

        return redirect()->away($app_link->link_to_dashboard);
    }

    public function completed_app_data(Request $request)
    {
        $validateData = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $amount = DB::table('applications')->where('app_id', $request->application_id)->select('amount_paid')->first();
        $percentage = DB::table('staff')->where('id', Auth::guard('staff')->user()->id)->select('percentage')->first();
        $my_percentage = ((intval($amount->amount_paid) * $percentage->percentage) / 100);

        $postponed_application_data = [
            'username' => $request->username,
            'password' => $request->password,
            'observation' => $request->observation,
            'status' => 'Complete',
            'assistant_pending_commission' => $my_percentage,
        ];

        if (DB::table('applications')->where('app_id', $request->application_id)->update($postponed_application_data)) {

            $request_info = DB::table('served_requests')->where('application_id', $request->application_id)->first();

            $url = url(route('app-payment', [
                'discipline' => $request_info->discipline_identifier,
                'rq' => $request_info->application_id,
                'clt' => $request_info->id,
            ]), false);

            $app = $request_info->discipline_name;
            $client = $request_info->names;

            Mail::to($request_info->email)->send(new CompletedApp($url, $client, $app));

            /*
            $phone = $request_info -> phone_number;

            if (substr(preg_replace('/[^0-9]/', '', $phone),0,4)=='2507' && strlen($phone)==12) {
            $phone = $phone;
            $rightphone = true;
            }
            else {
            if (substr(preg_replace('/[^0-9]/', '', $phone),0,2)=='07' && strlen($phone)==10) {
            $phone = '25'.$phone;
            $rightphone = true;
            }
            else {
            $rightphone = false;
            }
            }

            $uid = time().''.rand(100,999).''.rand(1000,9999);
            $returl = url(route('sms-callback'));

            //SMS
            $params = [
            'ohereza' => 'BSholarz',
            'kuri' => $phone,
            'ubutumwa' => urlencode('Your request for '. $app . ' has been processed successfully. Kindly, you are required to pay for the service by clicking this link: ' . $url),
            'client' => 'alexish',
            'password' => '0v4h5g8y9h7w',
            'msgid' => $uid,
            'receivedlr' => 'yes',
            'callurl' => $returl,
            'retype' => 'PLAIN',
            ];

            $apiUrl = 'https://api.sms.rw/';

            // Initialize cURL session
            $ch = curl_init();

            // Set cURL options
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Execute cURL session
            $response = curl_exec($ch);

            // Close cURL session
            curl_close($ch);

            // Process the response
            // return $response; // This might contain a success or error message from the API
             */

            return redirect()->route('staff-dashboard');

        } else {

            return back();

        }

    }

    public function mark_debtor_as_paid(Request $request)
    {
        $amount_paid = DB::table('applications')->where('app_id', $request->app_id)->where('assistant', Auth::guard('staff')->user()->id)->first();

        $atdg_amt_exp = explode(';', $amount_paid->outstanding_paid_amount);

        $sum = 0;

        foreach ($atdg_amt_exp as $key => $value) {

            $number = explode('=>', $value);
            $sum += intval($number[0]);

        }

        $partners = DB::table('rhythmbox')->get();

        $date = $date = new DateTime();
        $paid_amount = $amount_paid->outstanding_amount . '=>' . $date->format('Y-m-d H:i:s');

        Payment::create([
            'applicant_id' => $amount_paid->applicant,
            'application_id' => $request->app_id,
            'amount' => $amount_paid->outstanding_amount,
            'status' => 'Waiting For Review',
        ]);

        if ($amount_paid->outstanding_amount - $sum > 0) {

            $my_percentage = ((intval($amount_paid->outstanding_amount - $sum) * Auth::guard('staff')->user()->percentage) / 100);
            DB::table('applications')->where('app_id', $request->app_id)->limit(1)->update(['outstanding_payment_status' => 'Cleared', 'outstanding_paid_amount' => $paid_amount, 'assistant_pending_commission' => $my_percentage, 'remittance_status' => 'on hold', 'payment_status' => 'Waiting For Review', 'amount_paid' => $amount_paid->outstanding_amount]);
        } else {

            $my_percentage = ((intval($amount_paid->outstanding_amount) * Auth::guard('staff')->user()->percentage) / 100);
            DB::table('applications')->where('app_id', $request->app_id)->limit(1)->update(['outstanding_payment_status' => 'Cleared', 'outstanding_paid_amount' => $paid_amount, 'assistant_pending_commission' => $my_percentage, 'remittance_status' => 'on hold', 'payment_status' => 'Waiting For Review', 'amount_paid' => $amount_paid->outstanding_amount]);

        }

        foreach ($partners as $partner) {

            $percentage = $partner->pending_amount + (($amount_paid->outstanding_amount * $partner->percentage) / 100);

            DB::table('rhythmbox')->limit(1)->where('id', $partner->id)->update(['pending_amount' => $percentage]);

        }

        // Notify client
        $request_info = Applications::where('app_id', $request->app_id)->first();
        $data = [
            'discipline' => $request_info->discipline->discipline_name,
            'amount_paid' => $paid_amount,
            'client_names' => $request_info->user->names,
            'client_email' => $request_info->user->email,
            'client_phone' => $request_info->user->phone_number,
            'url' => url(route('client.client-dashboard')),
        ];

        Mail::to($request_info->user->email)->send(new PaymentReceived($data));

        $smsNotification = new Notifications();
        $utils = new Utils();

        // Send SMS notification
        $smsData = [
            'key' => $smsNotification->getSmsApiKey(),
            'message' => 'Dear ' . $request_info->user->names . ', Your payment for ' . $request_info->discipline->discipline_name . ' has been successfully received by BScholarz, Thank you for choosing BScholarz. We look forward to working with you again.',
            'recipients' => [
                $request_info->user->phone_number,
            ],
        ];

        $smsNotification->sendSms($smsData);

        return redirect()->route('staff-dashboard');
    }

    public function mark_partial_payment(Request $request)
    {

        $date = new DateTime();
        $app_info = DB::table('applications')->where('app_id', $request->app_id)->where('assistant', Auth::guard('staff')->user()->id)->first();
        $current_outstanding_amount = $app_info->outstanding_amount - $request->amountReceived;
        $assist_pending_amount = $app_info->assistant_pending_commission + (($request->amountReceived * Auth::guard('staff')->user()->percentage) / 100);

        $partners = DB::table('rhythmbox')->get();

        $atdg_amt_exp = explode(';', $app_info->outstanding_paid_amount);

        $sum = 0;

        foreach ($atdg_amt_exp as $key => $value) {

            $number = explode('=>', $value);
            $sum += intval($number[0]);

        }

        $check_sum = $sum + $request->amountReceived;

        if (intval($request->amountReceived) == $app_info->outstanding_amount) {

            DB::table('applications')->where('app_id', $request->app_id)->limit(1)->update(['outstanding_payment_status' => 'Cleared', 'outstanding_paid_amount' => $request->amountReceived . '=>' . $date->format('Y-m-d H:i:s'), 'assistant_pending_commission' => $assist_pending_amount, 'payment_status' => 'Waiting For Review', 'remittance_status' => 'on hold', 'amount_paid' => $request->amountReceived]);

            foreach ($partners as $partner) {

                $percentage = $partner->pending_amount + (($request->amountReceived * $partner->percentage) / 100);

                DB::table('rhythmbox')->limit(1)->where('id', $partner->id)->update(['pending_amount' => $percentage]);

            }

        } elseif ($check_sum == $app_info->outstanding_amount) {

            $new_amount = $app_info->outstanding_paid_amount . ';' . $request->amountReceived . '=>' . $date->format('Y-m-d H:i:s');

            DB::table('applications')->where('app_id', $request->app_id)->limit(1)->update(['outstanding_payment_status' => 'Cleared', 'outstanding_paid_amount' => $new_amount, 'assistant_pending_commission' => $assist_pending_amount, 'payment_status' => 'Waiting For Review', 'remittance_status' => 'on hold', 'amount_paid' => $request->amountReceived]);

            foreach ($partners as $partner) {

                $percentage = $partner->pending_amount + (($request->amountReceived * $partner->percentage) / 100);

                DB::table('rhythmbox')->limit(1)->where('id', $partner->id)->update(['pending_amount' => $percentage]);

            }

        } else {

            $new_amount = $app_info->outstanding_paid_amount . ';' . $request->amountReceived . '=>' . $date->format('Y-m-d H:i:s');

            DB::table('applications')->where('app_id', $request->app_id)->limit(1)->update(['outstanding_payment_status' => 'Partial payment', 'outstanding_paid_amount' => $new_amount, 'assistant_pending_commission' => $assist_pending_amount, 'remittance_status' => 'on hold', 'payment_status' => 'Partial Payment Waiting For Review', 'amount_paid' => $request->amountReceived]);

            foreach ($partners as $partner) {

                $percentage = $partner->pending_amount + (($request->amountReceived * $partner->percentage) / 100);

                DB::table('rhythmbox')->limit(1)->where('id', $partner->id)->update(['pending_amount' => $percentage]);

            }

        }

        Payment::create([
            'applicant_id' => $app_info->applicant,
            'application_id' => $request->app_id,
            'amount' => $request->amountReceived,
            'status' => 'Waiting For Review',
        ]);

        return back();

    }

    public function recordings(Request $request)
    {
        // Set week start and end days if needed
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);

        // Get the start and end of the current month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Query for completed applications within the current month
        $completedApp = DB::table('served_requests')
            ->where('assistant', Auth::guard('staff')->user()->id)
            ->where('application_status', 'Complete')
            ->whereBetween('served_on', [$startOfMonth, $endOfMonth])
            ->orderBy('served_on', 'desc')
            ->get();

        // Query for pending commissions within the current month
        $my_funds = DB::table('applications')
            ->select(DB::raw('sum(assistant_pending_commission) as commission'))
            ->where('assistant', Auth::guard('staff')->user()->id)
            ->where('payment_status', 'Confirmed')->orWhere('payment_status', 'Partial Payment Confirmed')
            ->where('remittance_status', 'on hold')
            ->where('payment_status', 'Confirmed')
            ->orWhere('payment_status', 'Partial Payment Confirmed')
            ->whereBetween('served_on', [$startOfMonth, $endOfMonth])
            ->first();

        // Query for balance within the current month
        $balance = DB::table('served_requests')
            ->where('assistant', Auth::guard('staff')->user()->id)
            ->where('application_status', 'Complete')
            ->where('payment_status', 'Confirmed')
            ->orWhere('payment_status', 'Partial Payment Confirmed')
            ->whereBetween('served_on', [$startOfMonth, $endOfMonth])
            ->get();

        return view('staff.sheet', compact('completedApp', 'my_funds', 'balance'));
    }

    public function sortRecsAll(Request $request)
    {
        $my_funds = DB::table('applications')
            ->select(DB::raw('sum(assistant_pending_commission) as commission'))
            ->where('assistant', Auth::guard('staff')->user()->id)
            ->where('remittance_status', 'on hold')
            ->where('payment_status', 'Confirmed')
            ->orWhere('payment_status', 'Partial Payment Confirmed')
            ->first();

        // Query for balance within the current month
        $balance = DB::table('served_requests')
            ->where('assistant', Auth::guard('staff')->user()->id)
            ->where('application_status', 'Complete')
            ->where('payment_status', 'Confirmed')
            ->orWhere('payment_status', 'Partial Payment Confirmed')
            ->get();

        $completedApp = DB::table('served_requests')
            ->where('assistant', Auth::guard('staff')->user()->id)
            ->where('application_status', 'Complete')
            ->orderBy('served_on', 'desc')
            ->get();

        return view('staff.sheet-all-apps', compact('completedApp', 'my_funds', 'balance'));
    }

    public function mark_as_greed(Request $request)
    {
        $app_info = DB::table('applications')->where('app_id', $request->app_id)->where('assistant', Auth::guard('staff')->user()->id)->first();
        $current_outstanding_amount = $app_info->outstanding_amount;

        $atdg_amt_exp = explode(';', $app_info->outstanding_paid_amount);

        $sum = 0;

        foreach ($atdg_amt_exp as $key => $value) {

            $number = explode('=>', $value);
            $sum += intval($number[0]);

        }

        $remaining_amount = $current_outstanding_amount - $sum;

        DB::table('applications')->where('app_id', $request->app_id)->where('assistant', Auth::guard('staff')->user()->id)->limit(1)->update(['amount_not_paid' => $remaining_amount, 'deliberation' => 'Refused to pay']);

        return back();
    }

    public function debtor_details(Request $request)
    {
        $my_funds = DB::table('applications')->select(DB::raw('sum(assistant_pending_commission) as commission'))->where('assistant', Auth::guard('staff')->user()->id)->where('remittance_status', 'on hold')->first();
        $completedApp = DB::table('served_requests')->where('assistant', Auth::guard('staff')->user()->id)->where('application_status', 'Complete')->orderBy('served_on', 'desc')->get();

        $debts = DB::table('served_requests')->where('id', $request->debtor_info)->where('amount_not_paid', '<>', 0)->whereNotNull('deliberation')->get();
        $debtor = DB::table('applicant_info')->where('id', $request->debtor_info)->first();

        return view('staff.debtors', compact('my_funds', 'completedApp', 'debts', 'debtor'));
    }

    public function assistance_requests()
    {

        $requests = DB::table('assistance_seekings')->whereNull('assistance_given')->get();

        return view('staff.assistance-requests', compact('requests'));

    }

    public function request_to_pay(Request $request)
    {
        $serviceInfo = DB::table('served_requests')
            ->where('application_id', $request->app_id)
            ->first();

        $client = $serviceInfo->names;
        $app = $serviceInfo->discipline_name;
        $date = $serviceInfo->served_on;
        $amount = $serviceInfo->outstanding_amount;

        if (Mail::to($serviceInfo->email)->send(new RequestToPay($client, $app, $date, $amount))) {

            DB::table('applications')
                ->where('app_id', $request->app_id)
                ->update(['poked' => 1]);

            session()->flash('poked', 'Poke email successfully sent');
        }

        return redirect()->back();

    }

    public function appointments()
    {
        $appointments = Applications::
            where('is_appointment', 1)->where('assistant', auth('staff')->user()->id)
            ->paginate(10);
        return view('admin.appointments', compact('appointments'));
    }

    public function comments()
    {
        return view('comments.comments', ['usr' => auth('staff')->user()]);
    }

}
