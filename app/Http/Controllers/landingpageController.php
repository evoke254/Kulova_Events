<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class landingpageController extends Controller
{
    //

    public function index(){
        /*if (Auth::check()) {
            return redirect()->route('dashboard');
        }*/
        return view('landing');
    }

    public function home(){

        return view('landing');
    }
}
