<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Room;
use App\Models\Category;
use App\Models\View;

class UserController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        $categories = Category::all();
        $views = View::all();
        return view('user.index', compact([
            'rooms', 'categories', 'views'
        ]));
    }

    public function show($id)
    {
        $room = Room::find($id);
        $categories = Category::all();
        $views = View::all();
        return view('user.show', compact(['room', 'categories', 'views']));
    }
}
