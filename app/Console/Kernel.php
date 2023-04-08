<?php

namespace App\Console;

use App\Models\Post;
use App\Jobs\PruneOldPostsJob;
use Illuminate\Support\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $posts = Post::where('published_at', '<=', Carbon::now()->subYears(2)->toDateTimeString())->get();
        $schedule->job(PruneOldPostsJob::dispatch($posts))->dailyAt("00:00");
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
