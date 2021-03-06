<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FarmerController extends Controller
{

    public function update(Request $request, $id)
    {
        if ($request->expectsJson()) {
            $validator = Validator::make($request->all(), [
                'name'  => 'required',
                'gender' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'land_area' => 'required|numeric',
                'address' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'messages' => $validator->messages(),
                    'success' => false
                ], 400);
            } else {
                try {

                    Farmer::where('id', $id)->update([
                        'name' => $request->name,
                        'gender' => $request->gender,
                        'phone' => $request->phone,
                        'email' => $request->email,
                        'birthplace' => $request->birthplace,
                        'birthday' => $request->birthday,
                        'land_area' => $request->land_area,
                        'address' => $request->address,
                    ]);

                    return response()->json([
                        'messages'  => ' Petani baru berhasil diubah',
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
