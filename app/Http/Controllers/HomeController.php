<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $rooms = Room::latest()
                ->take(6)
                ->get();
        } catch (\Throwable $e) {
            $rooms = new Collection();
        }

        return view('home.index', compact('rooms'));
    }
}
