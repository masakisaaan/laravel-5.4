<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class indexController extends Controller
{
    public function index()
    {
        $data = ['msg'=>'Your Name',];
            return view('template.index',$data);
    }   
    
    public function post(Request $request)
    {
        $msg = $request->msg;
        $data = ['msg'=>'Hello,' .$msg. '!',];
            return view('template.index',$data);    
    }
}
