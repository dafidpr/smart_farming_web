<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SensorController extends Controller
{
    public function store(Request $request)
    {
        if ($request->expectsJson()) {
            $validator = Validator::make(
                $request->all(),
                [
                    'serial_number' => 'required',
                    'temperature'  => 'required',
                    'humidity' => 'required',
                    'voltage'  => 'required',
                    'ampere' => 'required',
                    'watt' => 'required'
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'messages' => $validator->messages(),
                    'success' => false
                ], 400);
            } else {
                try {

                    Sensor::create([
                        'serial_number' => $request->serial_number,
                        'temperature'  => $request->temperature,
                        'humidity' => $request->humidity,
                        'voltage'  => $request->voltage,
                        'ampere' => $request->ampere,
                        'watt' => $request->watt
                    ]);

                    return response()->json([
                        'messages'  => ' Sensor berhasil ditambahkan',
                        'success' => true
                    ], 200);
                } catch (Exeption $e) {
                    return response()->json([
                        'messages' => 'Opps! Terjadi kesalahan',
                        'success' => false
                    ], 409);
                }
            }
        } else {
            abort(403);
        }
    }
}
