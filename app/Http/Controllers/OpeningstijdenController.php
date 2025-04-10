<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OpeningstijdenController extends Controller
{
    public function index()
    {
        return view('openingstijden.index');
    }
}
