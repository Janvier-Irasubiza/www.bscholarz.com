<?php

namespace App\Http\Controllers;

use App\Models\Advert;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MdController extends Controller
{

    public function dashboard()
    {
        return view('md.dashboard');
    }

    public function index()
    {
        // Cache all metrics under a single key to reduce overhead
        $dashboardData = Cache::remember('dashboard_data', now()->addMinutes(10), function () {
            return [
                'activeApps' => $this->getApplicationCount(),
                'xApps' => $this->getDeadlinedAppsCount(),
                'userRequestCount' => $this->getUserRequestCount(),
                'readyCustomerCount' => $this->getReadyCustomerCount(),
                'servedCustomerCount' => $this->getServedCustomerCount(),
                'activeEmployeeCount' => $this->getActiveEmployeeCount(),
                'assistanceRequestCount' => $this->getAssistanceRequestCount(),
                'requestedDeleteCount' => $this->getRequestedDeleteCount(),
                'activeAds' => $this->getActiveAdsCount(),
                'xAds' => $this->getXAdsCount(),
                'subs' => $this->getSubsCount(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $dashboardData,
        ]);
    }

    // Individual methods for each metric for clarity and maintainability
    private function getUserRequestCount()
    {
        return DB::table('user_requests')
            ->where('payment_status', 'Not yet paid')
            ->where('application_status', 'Pending')
            ->count();
    }

    private function getReadyCustomerCount()
    {
        return DB::table('user_requests')
            ->where('application_status', 'Pending')
            ->count();
    }

    private function getServedCustomerCount()
    {
        return DB::table('served_requests')
            ->where('payment_status', 'Paid')
            ->where('application_status', 'Complete')
            ->count();
    }

    private function getActiveEmployeeCount()
    {
        return DB::table('staff')
            ->where('status', 'Online')
            ->count();
    }

    private function getAssistanceRequestCount()
    {
        return DB::table('assistance_seekings')
            ->whereNull('assistance_given')
            ->count();
    }

    private function getRequestedDeleteCount()
    {
        return DB::table('user_requests')
            ->where('deletion_status', 'Requested')
            ->count();
    }

    private function getApplicationCount()
    {
        return DB::table('disciplines')
            ->where('category', '<>', 'Custom')
            ->where('due_date', '>', now())
            ->count();
    }

    private function getDeadlinedAppsCount()
    {
        return DB::table('disciplines')
            ->where('category', '<>', 'Custom')
            ->where('due_date', '<', now())
            ->count();
    }

    private function getActiveAdsCount() {
        return Advert::where('status', 'active')->count();
    }

    private function getXAdsCount() {
        return Advert::where('status','inactive')->count();
    }

    private function getSubsCount() {
        return Subscriber::count();
    }
}
