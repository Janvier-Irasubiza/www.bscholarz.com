<?php

namespace App\Console\Commands;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Console\Command;
use App\Models\Staff;
use Carbon\Carbon;
use DB;

class TrackStaffActivity extends Command {
  
   protected $signature = 'staff:tracking-activity';

   protected $description = 'Tracking staff activity';

   public function handle() {
     
     $threshold = now()->subMinutes(10)->format('Y-m-d H:i:s.u');
     
     Auth::guard('rhythmbox')->logout();

     Staff::where('last_activity', '<=', $threshold)
       ->where('status', 'Online')
       ->update(['status' => 'Offline']);

    }
  
}