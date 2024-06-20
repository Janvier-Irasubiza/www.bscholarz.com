<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ClientApplicationsController extends Controller {
    public function app_apply (Request $request) {
        if (DB::table('applications') -> where('app_id', $request -> request_id) -> where('status', 'Pending') -> first()) {
            DB::table('applications') -> where('app_id', $request -> request_id) -> limit(1) -> update(['status' => 'In progress']);
            return redirect() -> away($request -> applink);
        }

        else {
            return back();
        }
    }

    public function PostponeApp(Request $request) {
        DB::table('applications') -> where('app_id', $request -> request_id) -> limit(1) -> update(['status' => 'Postponed']);
        return back();
    }

    public function CompleteApp(Request $request) {
        DB::table('applications') -> where('app_id', $request -> request_id) -> limit(1) -> update(['status' => 'Complete', 'served_on' => date('Y-m-d H:i:s')]);
        return back();
    }
}
