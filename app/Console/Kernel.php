<?php

namespace App\Console;

use DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Inspire::class,
        Commands\LogDemo::class,
        Commands\SendNewsletter::class,
        Commands\InactiveTopics::class,
        Commands\getCurrency::class,
            //\App\Console\Commands\Inspire::class,
            //\App\Console\Commands\LogDemo::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
            $filePath='/home/indianic/Desktop/cronoutpur.txt';
        $schedule->command('inspire')
                ->everyMinute()
                ->sendOutputTo($filePath);

        $schedule->command('log:demo')
                ->everyThirtyMinutes();
        //->sendOutputTo(storage_path() . '/logs/cron.log')
        //->emailOutputTo('nikunj.kabariya@indianic.com');

        $schedule->command('send:newsletter')
                //->everyMinute();
        ->dailyAt('00:01');

        $schedule->command('inactive:topics')
            //->everyMinute();
            ->dailyAt('00:01');   

            // $filePath='/home/indianic/Desktop/cronoutpur.txt';
            // $schedule->command('get:currency')
            // ->everyMinute()
            // ->sendOutputTo($filePath);
            //->dailyAt('00:01');

        /* $schedule->call(function () {
          DB::table('recent_users')->delete();
          })->everyMinute();
        */
        
        //In addition to scheduling Closure calls, you may also schedule Artisan commands and operating system commands. For example, you may use the command method to schedule an Artisan command:
        //$schedule->command('emails:send --force')->daily();
        
        //The exec command may be used to issue a command to the operating system:
        //$schedule->exec('node /home/forge/script.js')->daily();
    }

}
