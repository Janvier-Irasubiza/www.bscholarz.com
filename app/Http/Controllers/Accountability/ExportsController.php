<?php

namespace App\Http\Controllers\Accountability;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;

class ExportsController extends Controller
{
    public function exportTransactions(Request $request)
{
    // Fetch transactions based on the type from query parameters
    $type = $request->query('type', 'pending'); // default to pending if no type is specified
    $transactions = [];

    // Initialize the query
    $query = DB::table('served_requests');

    if ($type === 'complete') {
        $query->where('payment_status', 'Confirmed');
    } else {
        $query->where('payment_status', 'Waiting For Review');
    }

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
    $transactions = $query->get();

    // Fetch employee name if sorted by employee
    $employeeName = null;
    if ($employee) {
        $employeeData = DB::table('staff')->where('id', $employee)->first();
        $employeeName = $employeeData ? $employeeData->names : null; // Get employee name
    }

    // Fetch application name if sorted by application
    $applicationName = null;
    if ($application) {
        $applicationData = DB::table('disciplines')->where('identifier', $application)->first();
        $applicationName = $applicationData ? $applicationData->discipline_name : null; // Get application name
    }

    // Check if the request is for downloading the Excel file
    if ($request->query('download') === 'excel') {
        // Define the export file name based on the type
        $fileName = $type === 'complete' ? 'complete_transactions.xlsx' : 'pending_transactions.xlsx';
        return Excel::download(new TransactionsExport($transactions, $sortBy, $employee, $employeeName, $application, $applicationName, $startDate, $endDate), $fileName);
    }

    // Render the appropriate view based on the type
    return view('accountant.' . ($type === 'complete' ? 'complete-transactions' : 'pending-transactions'), compact('transactions'));
}
}
