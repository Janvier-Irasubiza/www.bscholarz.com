<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;

class putAppToRest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bbg:put-application-to-rest';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Unpublish ended applications';

    /**
     * Execute the console command.
     */

    public function handle() {
      
      	date_default_timezone_set('Africa/Kigali');
      
      	$date_now = Carbon::now()->format('Y-m-d H:i:s.u');
      
        $applications = DB::table('disciplines') -> get();
      
      	foreach($applications as $app) {
        
          $app_due_date = Carbon::parse($app -> due_date);

          if ($app_due_date -> isSameDay($date_now) && $date_now -> diffInHours($app_due_date) >= 0 && $date_now -> diffInMinutes($app_due_date) >= 0 && $date_now -> diffInSeconds($app_due_date) >= 0) {
          
            	DB::table('disciplines') -> limit(1) -> where('id', $app -> id) -> update(['status' => 'N/A']);
          
          }

        
        }
      	
      
    }
}