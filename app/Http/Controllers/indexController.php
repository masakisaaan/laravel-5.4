<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class indexController extends Controller
{
    public function index()
    {
        return view('template.index');
    }   
    
}
