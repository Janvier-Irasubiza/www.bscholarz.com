<?php

namespace App\Http\Controllers\Admin;

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
        return view('accountability.dashboard');
    }
}
