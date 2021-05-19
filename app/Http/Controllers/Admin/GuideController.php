<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guide;
use Illuminate\Support\Facades\Validator;
use Vinkla\Hashids\Facades\Hashids;
use File;

class GuideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Master Panduan',
            'mod'   => 'mod_guide',
            'guides' => Guide::all()
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
                'title' => 'required',
                'file' => 'required|mimes:pdf',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'messages' => $validator->messages()
                ], 400);
            } else {
                try {
                    $path = 'admin/uploads/files/guides/';
                    $fileName = '-';
                    if ($request->file('file') != null) {

                        $fileName = $request->file('file')->getClientOriginalName();
                        $request->file('file')->move(public_path($path), $fileName);
                    }
                    Guide::create([
                        'title' => $request->title,
                        'description' => $request->description != null ? $request->description : '-',
                        'file' => $fileName,
                    ]);

                    return response()->json([
                        'messages'  => 'Panduan baru berhasil ditambahkan',
                        'redirect'  => '/administrator/guides'
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
                    'response'  => Guide::find($ids[0]),
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
                'title' => 'required',
                'file' => 'required|mimes:pdf',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'messages' => $validator->messages()
                ], 400);
            } else {
                try {
                    $path = 'admin/uploads/files/guides/';
                    $help = Guide::findOrFail($ids[0]);
                    $fileName = $help->file;
                    if ($request->file('file') != null) {
                      
                        File::delete($path . $fileName);
                        $fileName = $request->file('file')->getClientOriginalName();
                        $request->file('file')->move(public_path($path), $fileName);
                    }
                    Guide::where('id', $ids[0])->update([
                        'title' => $request->title,
                        'description' => $request->description != null ? $request->description : '-',
                        'file' => $fileName,
                    ]);

                    return response()->json([
                        'messages'  => 'Data panduan berhasil diubah',
                        'redirect'  => '/administrator/guides'
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
        if(\Request::ajax()){
            try {
                $path = 'admin/uploads/files/guides/';
                $guide = Guide::findOrFail($ids[0]);
                if ($guide->file != null) {
                      
                    File::delete($path . $guide->file);
                }
                $guide->delete();

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
                $path = 'admin/uploads/files/guides/';
                $guide = Guide::whereIn('id', $request->id);
                
                foreach($guide->get() as $guideData){

                    if ($guideData->file != null) {
                    
                        File::delete($path . $guideData->file);
                    }
                }
               
                $guide->delete();

                return response()->json(['msg' => 'Data berhasil dihapus'], 200);
            } catch(Exception $e){
                return response()->json(['msg' => $e->getMessage()], 500);
            }
        } else {
            abort(403);
        }
    }

    public function guides()
    {
        $data = [
            'title' => 'Panduan Center',
            'mod'   => 'mod_guide',
            'guides' => Guide::all()
        ];
        return view('admin.' . $this->defaultLayout('guide.guide'), $data);
    }
}
