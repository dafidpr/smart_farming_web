<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SensorHistory;

class SensorHistoryController extends Controller
{
    public function getSensorHistory(Request $request, $serialNumber)
    {
        if ($request->expectsJson()) {
            try {
                return response()->json([
                    'data'  => SensorHistory::where('serial_number', $serialNumber)->limit(10)->get(),
                    'success' => true,
                ], 200);
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
