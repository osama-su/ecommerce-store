<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $admins = Admin::select('id','name')->get();
        //return $admins;
        return view('admin.dashboard',compact('admins'));
        
    }

}
