<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Carbon;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Validator;
use File;

class SettingController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Settings',
            'mod'   => 'mod_setting',
            'general' => Setting::where('groups', 'General')->get(),
            'config' => Setting::where('groups', 'Config')->get(),
            'image' => Setting::where('groups', 'Image')->get()
        ];
        return view('admin.'. $this->defaultLayout, $data);
    }

    public function edit($id)
    {
        $ids = Hashids::decode($id);
        $data = [
            'title' => 'Edit Settings',
            'mod'   => 'mod_setting',
            'settings' => Setting::find($ids[0]),
            'action' => '/administrator/settings/' . $id . '/update'
        ];
        return view('admin.'. $this->defaultLayout('setting.form'), $data);
    }

    public function update(Request $request, $id)
    {
        $ids = Hashids::decode($id);
        if (\Request::ajax()) {
            $validator = Validator::make($request->all(), [
                'group' => 'required',
                'option' => 'required',
                'value' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'messages' => $validator->messages()
                ], 400);
            } else {
                $path = 'admin/uploads/img/';
                $setting = Setting::findOrFail($ids[0]);
                $fileName = $setting->value;
                if ($request->file('value') != null) {
                    if ($fileName != 'logo.png' || $fileName != 'favicon.png') {
                        File::delete($path . $fileName);
                    }
                    $fileName = $request->file('value')->getClientOriginalName();
                    $request->file('value')->move(public_path($path), $fileName);
                }
                try {
                    $settingUpdate = Setting::where('id', $ids[0])->update([
                        'groups' => $request->group,
                        'options' => $request->option,
                        'value' => $setting->groups != 'Image' ? $request->value : $fileName,
                        'updated_by' => \getInfoLogin()->id,
                        'updated_at' => Carbon::now()
                    ]);

                    return response()->json([
                        'messages'  => 'Pengaturan berhasil diperbarui',
                        'redirect'  => '/administrator/settings'
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

    public function maintenanceMode($id)
    {
        $ids = Hashids::decode($id);
        if (\Request::ajax()) {
            try {
                $setting = Setting::findOrFail($ids[0]);
                $settingUpdate = Setting::where('id', $ids[0])->update(['value' => $setting->value == 'Y' ? 'N' : 'Y']);
                return response()->json([
                    'messages'  => 'Pengaturan berhasil diperbarui',
                    'redirect'  => '/administrator/settings'
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
