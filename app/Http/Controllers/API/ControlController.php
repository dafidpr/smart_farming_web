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
                return response()->json([
                    'data'  => Control::where('serial_number', $request->serial_number)->first(),
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

    public function lampStatusUpdate(Request $request)
    {
        if ($request->expectsJson()) {
            try {
                $findControl = Control::where('serial_number', $request->serial_number)->first();
                Control::where('serial_number', $request->serial_number)->update(['status' => $findControl->status == 1 ? 0 : 1]);
                return response()->json([
                    'messages'  => 'Control berhasil diperbarui',
                    'success' => true,
                    'data'  => Control::where('serial_number', $request->serial_number)->first()
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
