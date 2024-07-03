<?php

namespace App\Jobs;

use App\Services\ScheduleGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Jadwal;

class GenerateScheduleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $generator = new ScheduleGenerator();
        $bestSchedule = $generator->generate();
        foreach ($bestSchedule as $entry) {
            Jadwal::create($entry);
        }
        \Log::info('Schedule generated and saved to database.');
    }
}
