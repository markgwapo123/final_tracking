<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log; // Add this line

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
{
    // Mandatory cleanup task
    $schedule->call(function () {
        Log::info('Scheduler ran at: '.now()); // Add this line
        // ... existing cleanup code ...
    })->everyFiveMinutes();
}

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}