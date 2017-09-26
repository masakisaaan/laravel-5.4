<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class indexController extends Controller
{
    public function index(){
        $data = ['msg'=>'Use Blade Template Sample..',];
            return view('template.index',$data);
        }   
}
