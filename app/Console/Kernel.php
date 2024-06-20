<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */

     protected $commands = [
        'App\Console\Commands\AdsRevenueCalc',
        'App\Console\Commands\reReadyRequest',
        'App\Console\Commands\putAppToRest',
        'App\Console\Commands\DeleteExpiredToken',
        'App\Console\Commands\DeleteRequest',
        'App\Console\Commands\TrackPartnerActivity',
        'App\Console\Commands\TrackStaffActivity',
        'App\Console\Commands\UnpostDeadlinedApps',
     ];

    protected function schedule(Schedule $schedule): void
    {
       	$schedule->command('bbg:ads-revenue-calc')->daily();
      	$schedule->command('bbg:re-ready-request')->everyMinute();
      	$schedule->command('bbg:put-application-to-rest')->daily();
      	$schedule->command('tokens:clean')->everyMinute();
      	$schedule->command('requests:delete')->daily();
      	$schedule->command('partner:tracking-activity')->everyMinute();
      	$schedule->command('staff:tracking-activity')->everyMinute();
      	$schedule->command('apps:unpost-deadlined')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
