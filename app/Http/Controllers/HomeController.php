<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        
        
        /*if(Auth::guard('users')->user()){
            die("a");
        }else{
            die("s");
        }
        die;*/
        
        /*if(admins()->user()){
            die("a");
        }else{
            die("s");
        }*/

        return view('front.home');
    }
    
    public function unsubscribeNewsletter($userId){
        echo $userId;die;
    }

}
