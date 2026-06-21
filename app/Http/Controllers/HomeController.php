<?php

namespace App\Http\Controllers;

use App\Models\Room;

class HomeController extends Controller
{
    public function index()
    {
        $rooms = Room::latest()
            ->take(6)
            ->get();

        return view('home.index', compact('rooms'));
    }
}