<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'title' => 'Analytics Dashboard'
        ];
        return view('admin.'. $this->defaultLayout, $data);
    }
}
