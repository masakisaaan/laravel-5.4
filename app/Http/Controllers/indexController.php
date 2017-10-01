<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;

class IndexController extends Controller
{
    public function index()
    {
        return view('index');
    }   
}
