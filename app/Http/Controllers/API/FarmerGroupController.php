<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FarmerGroup;

class FarmerGroupController extends Controller
{
    public function getFarmerGroup(Request $request)
    {
        if ($request->expectsJson()) {
            try {
                return response()->json([
                    'data'  => FarmerGroup::all(),
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
