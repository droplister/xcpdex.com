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
        Commands\UpdateMarketsCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Useful Switch
        if(config('xcp-core.indexing'))
        {
            $schedule->command('update:index')->everyMinute();
            $schedule->command('update:mempool')->everyMinute();
            $schedule->command('update:opensea')->everyFiveMinutes();
            $schedule->command('update:scarcecity')->everyFiveMinutes();
            $schedule->command('update:markets')->daily();
        }
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
    }
}
