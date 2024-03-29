<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\bundleExpirationCommand'::class,
        'App\Console\Commands\bonusExpirationCommand'::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('bundle:expired')->everyMinute();//->runInBackground();
        $schedule->command('change:segmentation')->everyMinute();//->runInBackground();
        $schedule->command('bonus:expired')->daily();//->runInBackground();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');

        // $this->call('bundleExpirationCommand'::class);
        // $this->call('bonusExpirationCommand'::class);
    }
}
