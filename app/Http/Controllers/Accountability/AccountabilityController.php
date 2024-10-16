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
        return view('accountant.pendding-transactions');
    }

    public function transaction_review() {
        return view('accountant.transaction-review');
    }

    public function accountant_deptors() {
        return view('accountant.debtors');
    }
}
