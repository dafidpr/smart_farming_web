<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Control;
use App\Models\Sensor;
use App\Models\SensorHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SensorController extends Controller
{
    public function store(Request $request)
    {
        if ($request->expectsJson()) {
            try {
                $findData = Sensor::where('serial_number', $request->serial_number);
                if ($findData->count() > 0) {

                    Sensor::where('serial_number', $request->serial_number)->update([
                        'serial_number' => $request->serial_number,
                        'temperature'  => $request->temperature,
                        'humidity' => $request->humidity,
                        'voltage'  => $request->voltage,
                        'current' => $request->current,
                        'power' => $request->power
                    ]);
                } else {
                    Sensor::create([
                        'serial_number' => $request->serial_number,
                        'temperature'  => $request->temperature,
                        'humidity' => $request->humidity,
                        'voltage'  => $request->voltage,
                        'current' => $request->current,
                        'power' => $request->power
                    ]);
                }

                SensorHistory::create([
                    'serial_number' => $request->serial_number,
                    'temperature'  => $request->temperature,
                    'humidity' => $request->humidity,
                    'voltage'  => $request->voltage,
                    'current' => $request->current,
                    'power' => $request->power
                ]);
                $control = Control::where('serial_number', $request->serial_number)->first();

                return response()->json([
                    'messages'  => ' Success',
                    'success' => true,
                    'lamp'  => $control->lamp,
                    'pump'  => $control->pump
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

    public function getTemperatureHumidity(Request $request, $serialNumber)
    {
        if ($request->expectsJson()) {
            try {
                return response()->json([
                    'data'  => Sensor::where('serial_number', $serialNumber)->first(),
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
