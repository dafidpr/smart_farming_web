<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Vinkla\Hashids\Facades\Hashids;
use DataTables;
use Illuminate\Database\QueryException;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Roles',
            'mod'   => 'mod_role',
            'roles' => Role::where('name', '!=', 'Developer')->get()
        ];
        return view('admin.' . $this->defaultLayout, $data);
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
                'role'      => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'messages' => $validator->messages()
                ], 400);
            } else {

                try {
                    Role::create([
                        'name'      => $request->role,
                    ]);

                    return response()->json([
                        'messages'  => 'Role baru berhasil ditambahkan',
                        'redirect'  => '/administrator/roles'
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
                    'response'  => Role::find($ids[0]),
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
        $ids = Hashids::decode($id);

        $remappedPermission = [];
        $permissions = Permission::all()->pluck('name');

        foreach ($permissions as $permission) {
            $remappedPermission[explode('-', $permission)[1]][] = $permission;
        }

        $data = [
            'title' => 'Change Permission',
            'mod' => 'mod_role',
            'role' => Role::findOrFail($ids[0]),
            'permissions' => $remappedPermission,
            'action' => '/administrator/roles/' . $id . '/change-permission'
        ];

        return view('admin.' . $this->defaultLayout('role.change'), $data);
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
            $validator = Validator::make($request->All(), [
                'role'      => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'messages' => $validator->messages()
                ], 400);
            } else {
                try {
                    Role::where('id', $ids[0])->update([
                        'name'      => $request->role,
                    ]);
                    return response()->json([
                        'messages'  => 'Role berhasil diubah',
                        'redirect'  => '/administrator/roles'
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
                $role = Role::findOrFail($ids[0]);
                $role->delete();

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
                Role::whereIn('id', $request->id)->delete();

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

    public function changePermission(Request $request, $id)
    {
        $ids = Hashids::decode($id);
        if (\Request::ajax()) {

            try {
                $role = Role::findOrFail($ids[0]);
                if ($request->has('permission')) {
                    $role->syncPermissions($request->permission);
                }
                return response()->json([
                    'messages'  => 'Hak akses user berhasil diperbarui',
                    'redirect'  => '/administrator/roles'
                ], 200);
            } catch (Exeption $e) {
                return response()->json([
                    'messages' => 'Opps! Terjadi kesalahan '
                ], 409);
            }
        } else {
            abort(403);
        }
    }
}
