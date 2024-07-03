<?php

namespace App\Http\Controllers;

use App\Services\ScheduleGenerator;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function generateSchedule()
    {
        $generator = new ScheduleGenerator();
        $bestSchedule = $generator->generate();
        // Save to database or other operations
        return response()->json([
            'message' => 'Schedule generation completed successfully.',
            'schedule' => $bestSchedule
        ]);
    }
}
