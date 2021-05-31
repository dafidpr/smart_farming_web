<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Validator;
use App\Models\Farmer;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $ids = Hashids::decode($id);
        $farmer = Farmer::find($ids[0]);
        $data = [
            'title' => 'Buat Penjadwalan',
            'mod'   => 'mod_schedule',
            'serial_number' => $farmer->serial_number,
            'schedules' => Schedule::where('serial_number', $farmer->serial_number)->get()
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
            $validator = Validator::make($request->all(), [
                'start' => 'required',
                'end'  => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'messages' => $validator->messages()
                ], 400);
            } else {
                try {
                    $ids = Hashids::decode($request->hashid);
                    $farmer = Farmer::find($ids[0]);
                    Schedule::create([
                        'serial_number' => $farmer->serial_number,
                        'start' => $request->start,
                        'end'  => $request->end,
                    ]);

                    return response()->json([
                        'messages'  => 'Jadwal baru berhasil ditambahkan',
                        'redirect'  => '/administrator/farmers/schedules/' . $request->hashid . '/create'
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
                    'response'  => Schedule::find($ids[0]),
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
                'start' => 'required',
                'end'  => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'messages' => $validator->messages()
                ], 400);
            } else {
                try {
                    Schedule::where('id', $ids[0])->update([
                        'start' => $request->start,
                        'end'  => $request->end,
                    ]);

                    return response()->json([
                        'messages'  => 'Jadwal berhasil diubah',
                        'redirect'  => '/administrator/farmers/schedules/' . $id . '/create'
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
                $schedule = Schedule::findOrFail($ids[0]);
                $schedule->delete();

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

    public function setSchedule($id)
    {
        $ids = Hashids::decode($id);
        if (\Request::ajax()) {
            try {
                $schedule = Schedule::findOrFail($ids[0]);
                $scheduleUpdate = Schedule::where('id', $ids[0])->update(['is_active' => $schedule->is_active == 1 ? 0 : 1]);
                return response()->json([
                    'messages'  => 'Pengaturan berhasil diperbarui',
                    'is_active' => Schedule::findOrFail($ids[0])->is_active
                ], 200);
            } catch (Exeption $e) {
                return response()->json([
                    'messages' => 'Opps! Terjadi kesalahan',
                ], 409);
            }
        } else {
            abort(403);
        }
    }
}
