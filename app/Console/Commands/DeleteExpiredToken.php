<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;

class DeleteExpiredToken extends Command {
  
   protected $signature = 'tokens:clean';

    protected $description = 'Delete expired password reset tokens';

    public function handle() {
      
      	date_default_timezone_set('Africa/Kigali');
      
      	$threshold = Carbon::now()->subMinutes(30)->format('Y-m-d H:i:s.u');
      
        $expiredTokens = DB::table('password_reset_tokens') ->  where('created_at', '<=', $threshold) -> delete();
      }
}