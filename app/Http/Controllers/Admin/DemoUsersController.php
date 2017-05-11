<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\DataTables\UsersDataTable;

class DemoUsersController extends Controller {

    public function __construct() {
        //$this->middleware('auth:admin');
    }
    
    public function index(UsersDataTable $dataTable) {
        $page_title = 'All Users';
        $page_description = 'Listing of all users';
        return $dataTable->render('admin.users.index', compact('page_title', 'page_description'));
    }

}
