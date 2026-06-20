<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $rooms = [];
        return view('home.index', compact('rooms'));
    }
}
