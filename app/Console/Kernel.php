<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\CashRegisterController;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $env = config('app.env');
        $email = env('MAIL_USERNAME');

        if ($env === 'live') {
            //Scheduling backup, specify the time when the backup will get cleaned & time when it will run.
            $schedule->command('backup:run')->dailyAt('23:30');

            //Subscription expiry email for superadmin
            $schedule->command('pos:sendSubscriptionExpiryAlert')->daily();
        }

        if ($env === 'demo' && !empty($email)) {
            //IMPORTANT NOTE: This command will delete all business details and create dummy business, run only in demo server.
            $schedule->command('pos:dummyBusiness')
                    ->cron('0 */2 * * *')
                    //->everyThirtyMinutes()
                    ->emailOutputTo($email);
        }

        $schedule->call(function () {
            $controller = app(CashRegisterController::class);
            $controller->autoCloseOverdueRegisters();
        })->daily()->at('00:01');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
