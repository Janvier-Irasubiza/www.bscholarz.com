<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;

class reReadyRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bbg:re-ready-request';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Retrieve back request into ready requests pull';

    /**
     * Execute the console command.
     */

    public function handle() {
      
      	date_default_timezone_set('Africa/Kigali');
      
      	$date_now = Carbon::now()->format('Y-m-d H:i:s.u');
      
        $reviewed_apps = DB::table('applications') -> where('status', 'Under Review') -> where('review_ccl', 'yes') -> get();
      
      
      	foreach($reviewed_apps as $application) {
         
          $req_review_datetime = Carbon::parse($application -> revied_on);
          
          if($req_review_datetime -> diffInHours($date_now) >= 4) {
          
            DB::table('applications') -> limit(1) -> where('app_id', $application -> app_id) -> update(['status' => 'Pending']);
            
          }
          
        }
      
    }
}