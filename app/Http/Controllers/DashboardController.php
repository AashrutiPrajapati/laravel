<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $request->session()->forget('customerId');
        $request->session()->forget('id');
        $request->session()->forget('show');
        $request->session()->forget('paginate');
        $request->session()->forget('search');
        return view('dashboard.index');
    }
}
