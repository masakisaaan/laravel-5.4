<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index($id='noname',$pass='unknown'){

        return <<<EOF
    
<html>
<head>
<title>Index</title>
<style>
body { font-size:16px; color:#999; }
h1 { font-size:100px; text-align:right; color:#eee;
    margin:-40px 0px -50px 0px; }
</style>
</head>
<body>
    <h1>Index</h1>
    <p>Hello,Index..</p>
    <ul>
        <li>ID: {$id}</li>
        <li>PASS: {$pass}</li>
    </ul>
</body>
</html>
EOF;

    }
}
