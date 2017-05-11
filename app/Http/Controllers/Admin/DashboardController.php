<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller {

    public function index() {
        \Flash::message('Welcome to dashboard!');
        return view('admin.dashboard.index');
    }
    
    public function underConstruction(){
        return view('admin.public.under_construction');
    }
}
