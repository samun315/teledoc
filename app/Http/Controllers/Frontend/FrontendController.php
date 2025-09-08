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

    function contactUs(){
        return view('frontend.contactUs');
    }

    function about(){
        return view('frontend.about');
    }

    function blog(){
        return view('frontend.blog');
    }
}
