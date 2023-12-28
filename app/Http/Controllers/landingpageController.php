<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class landingpageController extends Controller
{
    //

    public function index(){
        $events = Event::orderBy('start_date', 'Desc')->get();

        return view('landing', compact('events'));
    }


}
