<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;

class indexController extends Controller
{
    public function __construct()
    {
      parent::__construct();
    }  
    
    public function index()
    {
        return view('welcome');
    }   
}
