<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FarmerGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Database\QueryException;

class FarmerGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Kelompok Tani',
            'mod'   => 'mod_farmer_group',
            'farmerGroups' => FarmerGroup::all()
        ];
        return view('admin.' . $this->defaultLayout('farmer_group.index'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Kelompok Tani Baru',
            'mod'   => 'mod_farmer_group',
            'action' => '/administrator/farmer-groups/store'
        ];
        return view('admin.' . $this->defaultLayout('farmer_group.form'), $data);
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
                'chairman'  => 'required',
                'year'     => 'required',
                'address'  => 'required',
                'latitude'     => 'required',
                'longitude'     => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'messages' => $validator->messages()
                ], 400);
            } else {
                try {

                    FarmerGroup::create([
                        'name'      => $request->name,
                        'chairman'  => $request->chairman,
                        'year_formed'     => $request->year,
                        'number_of_members' => 0,
                        'address'     => $request->address,
                        'latitude'     => $request->latitude,
                        'longitude'     => $request->longitude,
                    ]);

                    return response()->json([
                        'messages'  => 'Kelompok Tani baru berhasil ditambahkan',
                        'redirect'  => '/administrator/farmer-groups'
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
        $ids = Hashids::decode($id);
        $data = [
            'title' => 'Edit Kelompok Tani Baru',
            'mod'   => 'mod_farmer_group',
            'farmerGroup' => FarmerGroup::find($ids[0]),
            'action' => '/administrator/farmer-groups/' . $id . '/update'
        ];
        return view('admin.' . $this->defaultLayout('farmer_group.form'), $data);
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
                'chairman'  => 'required',
                'year'     => 'required',
                'address'  => 'required',
                'latitude'     => 'required',
                'longitude'     => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'messages' => $validator->messages()
                ], 400);
            } else {
                try {

                    FarmerGroup::where('id', $ids[0])->update([
                        'name'      => $request->name,
                        'chairman'  => $request->chairman,
                        'year_formed'     => $request->year,
                        'number_of_members' => 0,
                        'address'     => $request->address,
                        'latitude'     => $request->latitude,
                        'longitude'     => $request->longitude,
                    ]);

                    return response()->json([
                        'messages'  => 'Kelompok Tani baru berhasil diubah',
                        'redirect'  => '/administrator/farmer-groups'
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
                $farmerGroup = FarmerGroup::findOrFail($ids[0]);
                $farmerGroup->delete();

                return response()->json([
                    'msg' => 'Data berhasil dihapus'
                ]);
            } catch (QueryException $e) {
                if ($e->getCode() === '23000') {
                    return response()->json(['msg' => 'Gagal menghapus karena data ini masih di gunakan oleh data lain'], 500);
                } else {
                    return response()->json(['msg' => $e->getMessage()], 500);
                }
            }
        } else {
            abort(403);
        }
    }

    public function multipleDelete(Request $request)
    {
        if (\Request::ajax()) {
            try {
                FarmerGroup::whereIn('id', $request->id)->delete();

                return response()->json(['msg' => 'Data berhasil dihapus'], 200);
            } catch (QueryException $e) {
                if ($e->getCode() === '23000') {
                    return response()->json(['msg' => 'Gagal menghapus karena data ini masih di gunakan oleh data lain'], 500);
                } else {
                    return response()->json(['msg' => $e->getMessage()], 500);
                }
            }
        } else {
            abort(403);
        }
    }
}
