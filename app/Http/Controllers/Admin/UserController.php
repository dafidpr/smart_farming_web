<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use App\Models\FarmerGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Exception;
use Vinkla\Hashids\Facades\Hashids;
use File;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Users',
            'mod'   => 'mod_user',
            'users' => User::whereHas('roles', function ($q) {
                $q->where('name', '!=', 'Developer');
            })->get(),
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
        $data = [
            'title' => 'Tambah User Baru',
            'mod'   => 'mod_user',
            'roles' => Role::where('name', '!=', 'Developer')->get(),
            'farmerGroups' => FarmerGroup::all(),
            'action' => '/administrator/users/store'
        ];
        return view('admin.' . $this->defaultLayout('user.form'), $data);
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
                'username'  => 'required',
                'email'     => 'required|email|unique:users,email',
                'password'  => 'required',
                'block'     => 'required',
                'picture'   => 'image|mimes:jpg,jpeg,png,gif',
                'farmer_group'  => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'messages' => $validator->messages()
                ], 400);
            } else {
                try {
                    $path = 'admin/uploads/img/profile/';
                    $fileName = 'user_pic.png';
                    if ($request->file('picture') != null) {

                        $fileName = $request->file('picture')->getClientOriginalName();
                        $request->file('picture')->move(public_path($path), $fileName);
                    }
                    $user = User::create([
                        'farmer_group_id' => $request->farmer_group,
                        'name'      => $request->name,
                        'username'  => $request->username,
                        'email'     => $request->email,
                        'password'  => Hash::make($request->password),
                        'block'     => $request->block,
                        'picture'   => $fileName,
                        'phone_number' => $request->phone != null ? $request->phone : '-',
                        'created_by' => \getInfoLogin()->id,
                        'updated_by' => \getInfoLogin()->id
                    ]);
                    $user->assignRole($request->role);

                    return response()->json([
                        'messages'  => 'User baru berhasil ditambahkan',
                        'redirect'  => '/administrator/users'
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
        $data = [
            'title' => 'Detail User',
            'mod'   => 'mod_user',
            'user' => User::with('roles')->find($ids[0]),
        ];
        return view('admin.' . $this->defaultLayout('user.detail'), $data);
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
            'title' => 'Edit User',
            'mod'   => 'mod_user',
            'roles' => Role::where('name', '!=', 'Developer')->get(),
            'user' => User::with('roles')->find($ids[0]),
            'farmerGroups' => FarmerGroup::all(),
            'action' => '/administrator/users/' . $id . '/update'
        ];
        return view('admin.' . $this->defaultLayout('user.form'), $data);
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
        $user = User::findOrFail($ids[0]);
        if (\Request::ajax()) {
            $validator = Validator::make($request->all(), [
                'name'      => 'required',
                'username'  => 'required',
                'email'     => 'required|email',
                'block'     => 'required',
                'picture'   => 'image|mimes:jpg,jpeg,png,gif',
                'farmer_group'  => Rule::requiredIf(function () use ($user) {
                    return $user->roles[0]['name'] != 'Developer';
                }),
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'messages' => $validator->messages()
                ], 400);
            } else {

                try {
                    $path = 'admin/uploads/img/profile/';

                    $fileName = $user->picture;
                    if ($request->file('picture') != null) {
                        if ($fileName != 'user_pic.png') {
                            File::delete($path . $fileName);
                        }
                        $fileName = $request->file('picture')->getClientOriginalName();
                        $request->file('picture')->move(public_path($path), $fileName);
                    }
                    $userUpdate = User::where('id', $ids[0])->update([
                        'farmer_group_id' => $request->farmer_group,
                        'name'      => $request->name,
                        'username'  => $request->username,
                        'email'     => $request->email,
                        'block'     => $request->block,
                        'picture'   => $fileName,
                        'phone_number' => $request->phone != null ? $request->phone : '-',
                        'created_by' => \getInfoLogin()->id,
                        'updated_by' => \getInfoLogin()->id
                    ]);

                    if ($user->roles[0]['name'] != 'Developer') {

                        $user->syncRoles($request->role);
                    }

                    return response()->json([
                        'messages'  => 'User berhasil diubah',
                        'redirect'  => '/administrator/users'
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
                $user = User::find($ids[0]);
                $user->delete();

                return response()->json(['msg' => 'Data berhasil dihapus'], 200);
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
                User::whereIn('id', $request->id)->delete();

                return response()->json(['msg' => 'Data berhasil dihapus'], 200);
            } catch (Exception $e) {

                return response()->json(['msg' => $e->getMessage()], 500);
            }
        } else {
            abort(403);
        }
    }

    public function changePassword()
    {

        $data = [
            'title' => 'Ubah Password',
            'mod'   => 'mod_user',
        ];
        return view('admin.' . $this->defaultLayout('user.password'), $data);
    }

    public function updatePassword(Request $request)
    {
        $user = getInfoLogin();
        if (\Request::ajax()) {
            $validator = Validator::make(
                $request->all(),
                [
                    'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                        if (!\Hash::check($value, $user->password)) {
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
                    User::where('id', $user->id)->update(['password' => Hash::make($request->new_password)]);
                    return response()->json([
                        'messages'  => 'Password berhasil diubah',
                        'redirect'  => '/administrator/users/change_password'
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

    public function blockUser($id)
    {
        $ids = Hashids::decode($id);
        if (\Request::ajax()) {
            try {
                $user = User::findOrFail($ids[0]);
                $blockUser = User::where('id', $ids[0])->update(['block' => $user->block == 'Y' ? 'N' : 'Y']);
                return response()->json([
                    'messages'  => $user->block == 'N' ? 'User berhasil diblokir' : 'User berhasil di unblokir',
                    'redirect'  => '/administrator/users'
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
