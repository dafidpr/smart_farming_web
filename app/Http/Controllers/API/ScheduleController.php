<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function getSchedule(Request $request, $serialNumber)
    {
        if ($request->expectsJson()) {
            try {
                $schedule = Schedule::where('serial_number', $serialNumber)->first();
                if ($schedule->is_active == 0) {
                    return response()->json([
                        'messages' => 'Jadwal masih belum di aktifkan!',
                        'success' => true,
                    ], 200);
                } else {
                    return response()->json([
                        'schedule_start'  => $schedule->start,
                        'schedule_end' => $schedule->end,
                        'success' => true,
                    ], 200);
                }
            } catch (Exeption $e) {
                return response()->json([
                    'messages' => 'Opps! Terjadi kesalahan',
                    'success' => false
                ], 409);
            }
        } else {
            abort(403);
        }
    }
}
