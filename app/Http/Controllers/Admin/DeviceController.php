<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Vinkla\Hashids\Facades\Hashids;
use App\Models\Device;
use Exception;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Manajemen Perangkat',
            'mod'   => 'mod_device',
            'devices' => Device::all()
        ];
        return view('admin.' . $this->defaultLayout('device.index'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Request::ajax()) {
            $validator = Validator::make($request->all(), [
                'name'      => 'required',
                'serial_number'  => 'required|unique:devices,serial_number',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'messages' => $validator->messages()
                ], 400);
            } else {
                try {

                    Device::create([
                        'name'      => $request->name,
                        'serial_number'  => $request->serial_number,
                    ]);

                    return response()->json([
                        'messages'  => 'Perangkat baru berhasil ditambahkan',
                        'redirect'  => '/administrator/devices'
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ids = Hashids::decode($id);
        if (\Request::ajax()) {
            try {
                return response()->json([
                    'response'  => Device::find($ids[0]),
                ], 200);
            } catch (Exeption $e) {
                return response()->json([
                    'messages' => 'Opps! Terjadi kesalahan'
                ], 409);
            }
        } else {
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ids = Hashids::decode($id);
        if (\Request::ajax()) {
            $validator = Validator::make($request->all(), [
                'name'      => 'required',
                'serial_number'  => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'messages' => $validator->messages()
                ], 400);
            } else {
                try {

                    Device::where('id', $ids[0])->update([
                        'name'      => $request->name,
                        'serial_number'  => $request->serial_number,
                    ]);

                    return response()->json([
                        'messages'  => 'Perangkat berhasil diubah',
                        'redirect'  => '/administrator/devices'
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ids = Hashids::decode($id);
        if (\Request::ajax()) {
            try {
                $device = Device::findOrFail($ids[0]);
                $device->delete();

                return response()->json([
                    'msg' => 'Data berhasil dihapus'
                ]);
            } catch (Exception $e) {

                return response()->json(['msg' => $e->getMessage()], 500);
            }
        } else {
            abort(403);
        }
    }

    public function multipleDelete(Request $request)
    {
        if (\Request::ajax()) {
            try {
                Device::whereIn('id', $request->id)->delete();

                return response()->json(['msg' => 'Data berhasil dihapus'], 200);
            } catch (Exception $e) {

                return response()->json(['msg' => $e->getMessage()], 500);
            }
        } else {
            abort(403);
        }
    }
}
