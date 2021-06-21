<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Control;
use Illuminate\Http\Request;

class ControlController extends Controller
{
    public function getStatus(Request $request)
    {
        if ($request->expectsJson()) {
            try {
                $controlStatus = Control::where('serial_number', $request->serial_number)->first();
                return response()->json([
                    'lamp'  => $controlStatus->lamp,
                    'pump'  => $controlStatus->pump,
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

    public function controlUpdate(Request $request)
    {
        if ($request->expectsJson()) {
            try {
                $findControl = Control::where('serial_number', $request->serial_number)->first();
                if ($request->type == 'lamp') {
                    Control::where('serial_number', $request->serial_number)->update(['lamp' => $findControl->lamp == 1 ? 0 : 1]);
                } else {
                    Control::where('serial_number', $request->serial_number)->update(['pump' => $findControl->pump == 1 ? 0 : 1]);
                }
                return response()->json([
                    'messages'  => 'Control berhasil diperbarui',
                    'success' => true,
                    'lamp'  => Control::where('serial_number', $request->serial_number)->first()->lamp,
                    'pump'  => Control::where('serial_number', $request->serial_number)->first()->pump,
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
