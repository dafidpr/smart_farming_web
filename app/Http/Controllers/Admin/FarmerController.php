<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Control;
use App\Models\Farmer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Hash;
use App\Models\FarmerGroup;
use App\Models\Device;

class FarmerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $farmerGroupID = getInfoLogin()->farmer_group_id;
        $data = [
            'title' => 'Data Petani',
            'mod'   => 'mod_farmer',
            'farmers' => getInfoLogin()->roles[0]->name == 'Developer' ? Farmer::where('status', 'approve')->get() : Farmer::where(['status' => 'approve', 'farmer_group_id' => $farmerGroupID])->get(),
            'farmerPending' => getInfoLogin()->roles[0]->name == 'Developer' ? Farmer::where('status', 'pending')->get() : Farmer::where(['status' => 'pending', 'farmer_group_id' => $farmerGroupID])->get(),
            'farmerReject' => getInfoLogin()->roles[0]->name == 'Developer' ? Farmer::where('status', 'rejected')->get() : Farmer::where(['status' => 'rejected', 'farmer_group_id' => $farmerGroupID])->get()
        ];
        return view('admin.' . $this->defaultLayout('farmer.index'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $farmerGroupID = getInfoLogin()->farmer_group_id;
        $data = [
            'title' => 'Tambah Petani Baru',
            'mod'   => 'mod_farmer',
            'action' => '/administrator/farmers/store',
            'farmerGroups' => getInfoLogin()->roles[0]->name == 'Developer' ? FarmerGroup::all() : FarmerGroup::where('id', $farmerGroupID)->get()
        ];
        return view('admin.' . $this->defaultLayout('farmer.form'), $data);
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
                    'serial_number' =>  ['required', 'exists:devices,serial_number', function ($attribute, $value, $fail) use ($device) {
                        if (isset($device->is_used)) {
                            if ($device->is_used == 'Y') {

                                return $fail(__('Serial number has been used'));
                            }
                        }
                    }]
                ],
                [
                    'serial_number.exists' => 'Serial number not found'
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
                        'block' => $request->block,
                        'status' => 'approve',
                    ]);
                    Control::create(['serial_number' => $request->serial_number, 'condition' => 0]);
                    Device::where('serial_number', $request->serial_number)->update(['is_used' => 'Y']);

                    return response()->json([
                        'messages'  => 'Petani baru berhasil ditambahkan',
                        'redirect'  => '/administrator/farmers'
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $farmerGroupID = getInfoLogin()->farmer_group_id;
        $ids = Hashids::decode($id);
        $data = [
            'title' => 'Edit Petani',
            'mod'   => 'mod_farmer',
            'farmerGroups' =>  getInfoLogin()->roles[0]->name == 'Developer' ? FarmerGroup::all() : FarmerGroup::where('id', $farmerGroupID)->get(),
            'farmer' => Farmer::find($ids[0]),
            'action' => '/administrator/farmers/' . $id . '/update'
        ];
        return view('admin.' . $this->defaultLayout('farmer.form'), $data);
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
            $device = Device::where('serial_number', $request->serial_number)->first();
            $validator = Validator::make(
                $request->all(),
                [
                    'farmer_group_id' => 'required',
                    'username'  => 'required',
                    'name'  => 'required',
                    'gender' => 'required',
                    'phone' => 'required',
                    'email' => 'required',
                    'land_area' => 'required|numeric',
                    'serial_number' => ['required', 'exists:devices,serial_number', function ($attribute, $value, $fail) use ($device) {
                        if (isset($device->is_used)) {
                            if ($device->is_used == 'Y') {

                                return $fail(__('Serial number has been used'));
                            }
                        }
                    }]
                ],
                [
                    'serial_number.exists' => 'Serial number not found'
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'messages' => $validator->messages()
                ], 400);
            } else {
                try {
                    $serialNumberFarmer = Farmer::find($ids[0]);
                    Farmer::where('id', $ids[0])->update([
                        'farmer_group_id' => $request->farmer_group_id,
                        'username'  => $request->username,
                        'name' => $request->name,
                        'gender' => $request->gender,
                        'phone' => $request->phone,
                        'email' => $request->email,
                        'birthplace' => $request->birthplace,
                        'birthday' => $request->birthday,
                        'land_area' => $request->land_area,
                        'address' => $request->address,
                        'serial_number' => $request->serial_number,
                        'block' => $request->block,
                    ]);
                    Control::where('serial_number', $serialNumberFarmer->serial_number)->update(['serial_number' => $request->serial_number]);
                    Device::where('serial_number', $request->serial_number)->update(['is_used' => 'Y']);
                    Device::where('serial_number', $serialNumberFarmer->serial_number)->update(['is_used' => 'N']);

                    return response()->json([
                        'messages'  => 'Petani baru berhasil diubah',
                        'redirect'  => '/administrator/farmers'
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
                $farmer = Farmer::findOrFail($ids[0]);
                $farmer->delete();

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
                Farmer::whereIn('id', $request->id)->delete();

                return response()->json(['msg' => 'Data berhasil dihapus'], 200);
            } catch (Exception $e) {

                return response()->json(['msg' => $e->getMessage()], 500);
            }
        } else {
            abort(403);
        }
    }

    public function approve($id)
    {
        $ids = Hashids::decode($id);
        if (\Request::ajax()) {
            try {
                $farmer = Farmer::where('id', $ids[0])->update(['status' => 'approve']);
                $serialNumberFarmer = Farmer::find($ids[0]);
                Device::where('serial_number', $serialNumberFarmer->serial_number)->update(['is_used' => 'Y']);
                Control::create(['serial_number' => $serialNumberFarmer->serial_number, 'condition' => 0]);

                return response()->json([
                    'messages' => 'Data berhasil di approve'
                ]);
            } catch (Exception $e) {

                return response()->json(['messages' => $e->getMessage()], 500);
            }
        } else {
            abort(403);
        }
    }

    public function reject($id)
    {
        $ids = Hashids::decode($id);
        if (\Request::ajax()) {
            try {
                $farmer = Farmer::where('id', $ids[0])->update(['status' => 'rejected']);

                return response()->json([
                    'messages' => 'Data berhasil di reject'
                ]);
            } catch (Exception $e) {

                return response()->json(['messages' => $e->getMessage()], 500);
            }
        } else {
            abort(403);
        }
    }


    public function blockFarmer($id)
    {
        $ids = Hashids::decode($id);
        if (\Request::ajax()) {
            try {
                $farmer = Farmer::findOrFail($ids[0]);
                $blockFarmer = Farmer::where('id', $ids[0])->update(['block' => $farmer->block == 'Y' ? 'N' : 'Y']);
                return response()->json([
                    'messages'  => $farmer->block == 'N' ? 'Petani berhasil diblokir' : 'Petani berhasil di unblokir',
                    'redirect'  => '/administrator/farmer'
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
}
