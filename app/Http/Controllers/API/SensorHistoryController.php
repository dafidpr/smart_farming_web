<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SensorHistory;
use DB;

class SensorHistoryController extends Controller
{
    public function getSensorHistory(Request $request, $serialNumber)
    {
        if ($request->expectsJson()) {
            try {
                return response()->json([
                    'data'  => SensorHistory::where('serial_number', $serialNumber)->limit(20)->get(),
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

    public function getWattGraphics(Request $request, $serialNumber)
    {
        if ($request->expectsJson()) {
            try {
                $querySQL = "SELECT SUM(power) as power,  DATE_FORMAT(created_at, '%b') as bulan 
                                FROM sensor_histories WHERE id IN (SELECT MAX(id) FROM sensor_histories 
                                GROUP BY DATE_FORMAT(created_at, '%d')) AND serial_number = '$serialNumber' 
                                AND DATE_FORMAT(created_at, '%Y') = " . date('Y') . " GROUP BY DATE_FORMAT(created_at, '%m')";

                return response()->json([
                    'data'  => DB::select($querySQL),
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
