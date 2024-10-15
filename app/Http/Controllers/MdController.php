<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MdController extends Controller
{
    public function dashboard() {
        return view('md.dashboard');
    } 
}
