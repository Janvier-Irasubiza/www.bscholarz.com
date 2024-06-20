<?php

namespace App\Http\Controllers\RhythmBox;

use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use App\Models\RhythmBox;
use Carbon\Carbon;
use Auth;
use DB;
use File; 

class RhythmBoxController extends Controller {

    public function login () {

        if(!Auth::guard('rhythmbox') -> user()) {
            return view('auth.rb-a_auth');
        }

        else {
            return redirect() -> route('rhythmbox.dashboard');
        }
    }

    public function register() {
        return view('auth.rb-a_register');
    }

    public function create(Request $request) {
        $request -> validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:'.RhythmBox::class],
            'phone' => ['required', 'max:30'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = RhythmBox::create([
            'names' => $request -> name,
            'email' => $request -> email,
            'phone_number' => $request -> phone,
            'password' => Hash::make($request->password),
        ]);

        $rbInfo = $request -> all();

        if(event(new Registered($user))) {
            return redirect() -> route('rhythmbox.records') -> with(['scs_msg', 'Successfully created account for'.$request -> name   ]);
        }

        else {
            return back()->withErrors([
                'email' => 'Failed to create the account, try again',
            ])->onlyInput('email');
        }

    }

    public function auth(Request $rbInfo) {
        $rbInfo -> validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::guard('rhythmbox') -> attempt(['email' => $rbInfo -> email, 'password' => $rbInfo -> password])) {
            $rbInfo -> session() -> regenerate();
 
            DB::table('rhythmbox') -> where('id', Auth::guard('rhythmbox') -> user() -> id) -> limit(1) -> update(['active_status' => 'Online']);

            return redirect() -> route('rhythmbox.dashboard');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');

    }

    public function dashboard(Request $request) {
        $app_incomes = DB::table('served_requests') -> where('payment_status', 'Paid') -> where('application_status', 'Complete') -> get();
        $todayApps = DB::table('served_requests') -> where('payment_status', 'Paid') -> where('application_status', 'Complete') -> whereDate('served_on', Carbon::today()) -> get();
        $todayAds = DB::table('adverts') -> whereDate('posted_on', Carbon::today()) -> get();
        $assistantsCommission = DB::table('applications') -> select(DB::raw('sum(assistant_pending_commission) as commission')) -> where('assistant', $request -> assistant) -> where('remittance_status', 'on hold') -> first();

        $received_amount = DB::table('partners_payment_history') -> select(DB::raw('sum(paid_amount) as paid_amount')) -> first();

        $ads = DB::table('adverts') -> where('status', 'active') -> get();

        return view('rhythmbox.dashboard', compact('app_incomes', 'ads', 'todayApps', 'todayAds', 'assistantsCommission', 'received_amount'));
    }
  
  	public function disbursements(Request $request) {
      $history = DB::table('partners_payment_history') -> where('paid_to', Auth::guard('rhythmbox') -> user() -> id) -> orderBy('paid_at', 'DESC') -> get();
      return view('rhythmbox.disbursements', compact('history'));
    }

    public function org() {
        $staff = DB::table('staff') -> get();
        return view('rhythmbox.org', compact('staff'));
    }

    public function rba () {
        $staff = DB::table('rhythmbox') -> where('id', '<>', Auth::guard('rhythmbox') -> user() -> id) -> get();
        return view('rhythmbox.rba', compact('staff'));
    }

    public function recordings(Request $request) {

        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);

        $member = DB::table('staff') -> where('id', $request -> assistant) -> first();
        $completedApp = DB::table('served_requests') -> where('assistant', $request -> assistant) -> where('application_status', 'Complete') -> whereBetween('served_on', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]) -> orderBy('served_on', 'desc') -> get();
        $balance = DB::table('served_requests') -> where('assistant', $request -> assistant) -> where('application_status', 'Complete') -> get();
        return view('rhythmbox.sheet', compact('member', 'completedApp', 'balance'));
    }   

    public function sortRecsAll(Request $request) {
        $member = DB::table('staff') -> where('id', $request -> assistant) -> first();
        $completedApp = DB::table('served_requests') -> where('assistant', $request -> assistant) -> where('application_status', 'Complete') -> orderBy('served_on', 'desc') -> get();
        return view('rhythmbox.sheet-all-apps', compact('member', 'completedApp'));
    }

    public function admin () {
        $staff = DB::table('staff') -> get();
        $clients = DB::table('applicant_info') -> get();
        $clients_requests = DB::table('user_requests') -> get();
        $searches = DB::table('search_suggestions') -> orderBy('count', 'desc') -> get();

        $active_staff = 0;

        foreach ($staff as $member) {
            if($member -> status == 'Online') {
                $active_staff += 1;
            }
        }

        return view('rhythmbox.admin', compact('staff', 'clients', 'clients_requests', 'searches', 'active_staff'));
    }
  
    public function recycle_bin () {

        $requested_delete = DB::table('user_requests') -> where('deletion_status', 'Deletion Confirmed') -> get();

        return view('rhythmbox.recycle', compact('requested_delete'));

      }
  
  
  	public function recover_deleted (Request $request) {
      
        DB::table('applications') -> where('applicant', $request -> customer_info) -> where('app_id', $request -> application_info) -> update(['deletion_status' => NULL, 'deleted_on' => NULL]);


        return back();
    }

}