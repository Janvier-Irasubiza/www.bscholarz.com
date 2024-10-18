<?php

namespace App\Http\Controllers;
use App\Models\Comment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use DB;

class MdController extends Controller
{
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

        return view('md.dashboard', compact(
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
}
