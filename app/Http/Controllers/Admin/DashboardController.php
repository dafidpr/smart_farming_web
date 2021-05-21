<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use App\Models\FarmerGroup;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Models\Device;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'title' => 'Analytics Dashboard',
            'users' =>  User::all(),
            'devices' => Device::all(),
            'deviceUsed' => Device::where('is_used', 'Y')->get(),
            'deviceNoUsed' => Device::where('is_used', 'N')->get(),
            'userBlock' => User::where('block', 'Y')->get(),
            'userUnblock' => User::where('block', 'N')->get(),
            'farmers' => Farmer::where(['status' => 'approve', 'block' => 'N'])->get(),
            'farmerPending' => Farmer::where('status', 'pending')->get(),
            'farmerReject' => Farmer::where('status', 'rejected')->get(),
            'farmerBlock' => Farmer::where('block', 'Y')->get(),
        ];
        return view('admin.' . $this->defaultLayout, $data);
    }
}
