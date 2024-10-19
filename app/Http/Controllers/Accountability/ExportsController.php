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

class ExportsController extends Controller {
    public function exportCompleteTransactions() {
        \Log::info('Exporting complete transactions');

        // Fetch all confirmed transactions
        $complete_transactions = DB::table('applications')->where('payment_status', 'Confirmed')->get();

        return response()->json($complete_transactions);
    }


    public function sortTransactions(Request $request) {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Fetch transactions within the specified date range
        $sorted_transactions = DB::table('applications')
            ->where('payment_status', 'Confirmed')
            ->whereBetween('served_on', [$startDate, $endDate])
            ->get();

        return response()->json($sorted_transactions); // Return sorted transactions as JSON
    }

}
