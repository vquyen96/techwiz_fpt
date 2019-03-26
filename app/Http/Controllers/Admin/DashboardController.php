<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        //
    }

    public function show(Request $request)
    {
        return redirect()->route('admin.user.list');
    }
}
