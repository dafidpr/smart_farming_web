<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Vinkla\Hashids\Facades\Hashids;
class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Permissions',
            'mod'   => 'mod_permission',
            'permissions' => Permission::where('is_default', 'N')->get()
        ];
        return view('admin.'. $this->defaultLayout, $data);
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
            $validator = Validator::make($request->All(), [
                'name'      => 'required',
                'permission' => 'required|array|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'messages' => $validator->messages()
                ], 400);
            } else {

                try {
                    foreach ($request->permission as $permission) {
                        Permission::create([
                            'name'  => $permission . '-' . $request->name,
                            'is_default' => 'N'
                        ]);
                    }

                    return response()->json([
                        'messages'  => 'Permission baru berhasil ditambahkan',
                        'redirect'  => '/administrator/permissions'
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
        //
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
        if(\Request::ajax()){
            try {
                $permission = Permission::findOrFail($ids[0]);
                $permission->delete();

                return response()->json(['msg' => 'Data berhasil dihapus'], 200);
            } catch(Exception $e){
                return response()->json(['msg' => $e->getMessage()], 500);
            }
        } else {
            abort(403);
        }
    }

    public function multipleDelete(Request $request)
    {
        if(\Request::ajax()){
            try {
                $permission = Permission::whereIn('id', $request->id);
                $permission->delete();

                return response()->json(['msg' => 'Data berhasil dihapus'], 200);
            } catch(Exception $e){
                return response()->json(['msg' => $e->getMessage()], 500);
            }
        } else {
            abort(403);
        }
    }
}
