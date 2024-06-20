<?php

namespace App\Console\Commands;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Console\Command;
use App\Models\Staff;
use Carbon\Carbon;
use DB;

class UnpostDeadlinedApps extends Command { 
    
   protected $signature = 'apps:unpost-deadlined';

   protected $description = 'Unposting deadlined applications';

   public function handle() {
     
     DB::table('disciplines') -> where('due_date', '<', now() -> format('Y-m-d H:i:s.u')) -> update(['status' => 'N/A']);
     
   }
  
}