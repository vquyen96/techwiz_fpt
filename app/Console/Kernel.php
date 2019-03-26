<?php

namespace App\Console;

use App\Console\Commands\ConfirmReceivedProduct;
use App\Console\Commands\ExpiredRequest;
use App\Console\Commands\StopSellingProduct;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command(StopSellingProduct::class)
            ->everyMinute()
            ->withoutOverlapping();

        $schedule->command(ConfirmReceivedProduct::class)
            ->everyMinute()
            ->withoutOverlapping();

        $schedule->command(ExpiredRequest::class)
            ->everyMinute()
            ->withoutOverlapping();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require_once base_path('routes/console.php');
    }
}
