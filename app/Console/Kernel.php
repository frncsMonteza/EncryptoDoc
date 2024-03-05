<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Spatie\Backup\Commands\BackupCommand;
use Spatie\Backup\Commands\CleanupCommand;
use Spatie\Backup\Commands\MonitorCommand;
use Spatie\Backup\Tasks\Backup\BackupJob;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command(BackupCommand::class)->daily()->at('02:00');
        $schedule->command(CleanupCommand::class)->daily()->at('03:00');
        $schedule->command(MonitorCommand::class)->daily()->at('04:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}