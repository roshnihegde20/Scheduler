<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        'App\Console\Commands\storeUsers',
    ];

    /**
     * Define the application's command schedule.
     */
    
    protected function schedule(Schedule $schedule)
    {
        // Scheduleing command to run every 5 minutes
        $schedule->command('app:store-users')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}