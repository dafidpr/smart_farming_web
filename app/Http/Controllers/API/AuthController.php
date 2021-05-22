<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Device;
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
                            'success' => true,
                            'message' => 'Berhasil Login',
                            'data' => $farmer,
                            '_token' => $token
                        ], 200);
                    }
                }
            } catch (Exeption $e) {
                return response()->json([
                    'messages' => 'Opps! Terjadi kesalahan.',
                    'success' => false
                ], 409);
            }
        } else {
            abort(403);
        }
    }

    public function registerFarmer(Request $request)
    {
        if ($request->expectsJson()) {
            $device = Device::where('serial_number', $request->serial_number)->first();
            $validator = Validator::make(
                $request->all(),
                [
                    'farmer_group_id' => 'required',
                    'username'  => 'required|unique:farmers,username',
                    'password' => 'required',
                    'name'  => 'required',
                    'gender' => 'required',
                    'phone' => 'required',
                    'email' => 'required',
                    'land_area' => 'required|numeric',
                    'serial_number' => ['required', 'exists:devices,serial_number', function ($attribute, $value, $fail) use ($device) {
                        if (isset($device->is_used)) {
                            if ($device->is_used == 'Y') {

                                return $fail(__('Serial number sudah pernah digunakan.'));
                            }
                        }
                    }],
                    'address' => 'required'
                ],
                [
                    'serial_number.exists' => 'Serial number tidak ditemukan'
                ]
            );

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
                        'address' => $request->address,
                        'serial_number' => $request->serial_number,
                        'block' => 'N',
                        'status' => 'pending',
                    ]);

                    return response()->json([
                        'messages'  => ' Petani baru berhasil ditambahkan',
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

    public function logout(Request $request)
    {
        $farmer = $request->user();
        $farmer->currentAccessToken()->delete();
        return response()->json([
            'messages'  => 'Berhasil logout',
            'success' => true,
            'token' => $farmer->_token
        ], 200);
    }

    public function updatePassword(Request $request)
    {
        $farmer = $request->user();
        if ($request->expectsJson()) {
            $validator = Validator::make(
                $request->all(),
                [
                    'current_password' => ['required', function ($attribute, $value, $fail) use ($farmer) {
                        if (!\Hash::check($value, $farmer->password)) {
                            return $fail(__('The current password is incorrect.'));
                        }
                    }],
                    'new_password' => 'required|same:confirm_password',
                    'confirm_password' => 'required|same:new_password',
                ],
                [
                    'current_password.required' => 'Current password cannot be empty',
                    'new_password.same'    => 'Password is not the same as confirmation password.',
                    'new_password.required' => 'New password cannot be empty',
                    'confirm_password.same' => 'Confirm password is not the same as new password',
                    'confirm_password.required' => 'Confirm password cannot be empty'
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'messages' => $validator->messages()
                ], 400);
            } else {
                try {
                    Farmer::where('id', $farmer->id)->update(['password' => Hash::make($request->new_password)]);
                    return response()->json([
                        'messages'  => 'Password berhasil diubah',
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
