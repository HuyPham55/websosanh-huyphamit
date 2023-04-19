<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MediaController extends BaseController
{
    //
    public function getList(Request $request) {
        return view('admin.media.list');
    }
}
