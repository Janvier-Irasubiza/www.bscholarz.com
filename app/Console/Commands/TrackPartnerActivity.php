<?php

namespace App\Console\Commands;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Console\Command;
use App\Models\RhythmBox;
use Carbon\Carbon;
use DB;

class TrackPartnerActivity extends Command {
  
   protected $signature = 'partner:tracking-activity';

   protected $description = 'Tracking partner activity';

   public function handle() {
     
     $threshold = now()->subMinutes(15)->format('Y-m-d H:i:s.u');
     
     Auth::guard('rhythmbox')->logout();

     RhythmBox::where('last_activity', '<=', $threshold)
            ->where('active_status', 'Online')
            ->update(['active_status' => 'Offline']);

    }
  
}