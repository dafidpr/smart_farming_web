<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Control;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SensorController extends Controller
{
    public function store(Request $request)
    {
        if ($request->expectsJson()) {
            try {
                Sensor::create([
                    'serial_number' => $request->serial_number,
                    'temperature'  => $request->temperature,
                    'humidity' => $request->humidity,
                    'voltage'  => $request->voltage,
                    'current' => $request->current,
                    'power' => $request->power
                ]);

                return response()->json([
                    'messages'  => ' Sensor berhasil ditambahkan',
                    'success' => true,
                    'condition'  => Control::where('serial_number', $request->serial_number)->first()->condition,
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
