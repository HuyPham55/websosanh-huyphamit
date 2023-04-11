<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashBoardController extends BaseController
{
    //

    public function index(Request $request)
    {
        return view('admin.dashboard');
    }
}
