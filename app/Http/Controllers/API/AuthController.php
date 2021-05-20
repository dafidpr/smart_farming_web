<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\FarmerGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function postLogin(Request $request)
    {

        if ($request->expectsJson()) {

            try {

                $farmer = Farmer::where('username', $request->username)->first();

                if (!$farmer || !Hash::check($request->password, $farmer->password)) {

                    return response()->json([
                        'messages' => 'Username atau password salah'
                    ], 404);
                } else {
                    if ($farmer->block == 'Y') {
                        return response()->json([
                            'messages' => 'Akun anda telah diblokir'
                        ], 403);
                    } else if ($farmer->status != 'approve') {
                        return response()->json([
                            'messages' => 'Akun anda telah di tolak atau belum disetujui'
                        ], 403);
                    } else {

                        $token = $farmer->createToken('token-name')->plainTextToken;
                        return response()->json([
                            'message' => 'Berhasil Login',
                            'data' => $farmer,
                            '_token' => $token
                        ], 200);
                    }
                }
            } catch (Exeption $e) {
                return response()->json([
                    'messages' => 'Opps! Terjadi kesalahan.'
                ], 409);
            }
        } else {
            abort(403);
        }
    }

    public function registerFarmer(Request $request)
    {
        if ($request->expectsJson()) {
            $validator = Validator::make($request->all(), [
                'farmer_group_id' => 'required',
                'username'  => 'required|unique:farmers,username',
                'password' => 'required',
                'name'  => 'required',
                'gender' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'land_area' => 'required|numeric',
                'serial_number' => 'required|unique:farmers,serial_number',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'messages' => $validator->messages()
                ], 400);
            } else {
                try {

                    Farmer::create([
                        'farmer_group_id' => $request->farmer_group_id,
                        'username'  => $request->username,
                        'password' => Hash::make($request->password),
                        'name' => $request->name,
                        'gender' => $request->gender,
                        'phone' => $request->phone,
                        'email' => $request->email,
                        'birthplace' => $request->birthplace,
                        'birthday' => $request->birthday,
                        'land_area' => $request->land_area,
                        'serial_number' => $request->serial_number,
                        'block' => 'N',
                        'status' => 'pending',
                    ]);

                    $farmerGroup = FarmerGroup::find($request->farmer_group_id);
                    FarmerGroup::where('id', $request->farmer_group_id)->update([
                        'number_of_members' => $farmerGroup->number_of_members + 1
                    ]);


                    return response()->json([
                        'messages'  => ' Petani baru berhasil ditambahkan',
                    ], 200);
                } catch (Exeption $e) {
                    return response()->json([
                        'messages' => 'Opps! Terjadi kesalahan'
                    ], 409);
                }
            }
        } else {
            abort(403);
        }
    }

    public function logout(Request $request)
    {
        $farmer = $request->user();
        $farmer->currentAccessToken()->delete();
        return response()->json([
            'messages'  => 'Berhasil logout',
        ], 200);
    }
}
