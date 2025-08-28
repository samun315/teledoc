<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    function homePage(){
        //dd('test');
        return view('frontend.welcomePage');
    }

    function homePage2(){
        //dd('test');
        return view('frontend.welcomePage2');
    }
}
