<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;

class DeleteRequest extends Command {
  
   protected $signature = 'requests:delete';

    protected $description = 'Delete requests';

    public function handle() {
      
      	date_default_timezone_set('Africa/Kigali');
      
      	$threshold = Carbon::now()->subDays(7)->format('Y-m-d H:i:s.u');
      
      	DB::table('applications') -> where('deletion_status', 'Deletion Confirmed') -> where('deleted_on', '<=', $threshold) -> delete($rq -> id);
      
    }
  
}