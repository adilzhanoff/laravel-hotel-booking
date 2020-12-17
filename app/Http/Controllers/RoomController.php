<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Category;
use App\Models\View;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::all();
        $users = User::all();
        $categories = Category::all();
        $views = View::all();
        return view('admin.rooms.index', compact([
            'rooms', 'users', 'categories', 'views'
        ]));
    }

    public function roomsByUser($id) {
        $rooms = User::find($id)->rooms->all();
        $users = User::all();
        $categories = Category::all();
        $views = View::all();
        return view('admin.rooms.index', compact([
            'rooms', 'users', 'categories', 'views'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $views = View::all();
        return view('admin.rooms.create', compact(['categories', 'views']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'view_id' => 'required',
            'rate' => 'required',
        ]);

        try {
            $room = new Room([
                'number' => $request->get('number'),
                'description' => $request->get('description'),
                'category_id' => $request->get('category_id'),
                'view_id' => $request->get('view_id'),
                'rate' => $request->get('rate'),
            ]);
            $room->save();
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return redirect('admin/rooms/create')->withErrors(
                    ['custom' => 'Room with such number already exists!']
                );
            }
        }

        return redirect('admin/rooms')->with(
            'success', 'New room has been succesfully added!'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room = Room::find($id);
        $categories = Category::all();
        $views = View::all();
        return view('admin.rooms.show', compact(['room', 'categories', 'views']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $room = Room::find($id);
        $categories = Category::all();
        $views = View::all();
        return view('admin.rooms.edit', compact(['room', 'categories', 'views']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'number' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'view_id' => 'required',
            'rate' => 'required'
        ]);

        try {
            $room = Room::find($id);
            if (!($request->get('number') == $room->number)) {
                $room->number = $request->get('number');
            }
            $room->description = $request->get('description');
            $room->category_id = $request->get('category_id');
            $room->view_id = $request->get('view_id');
            $room->rate = $request->get('rate');
            $room->save();
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return redirect('admin/rooms/{room}/edit')->withErrors(
                    ['custom' => 'Room with such number already exists!']
                );
            }
        }

        return redirect('admin/rooms')->with(
            'success', 'The room has been succesfully edited!'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room = Room::find($id);
        $room->users()->detach();
        $room->delete();
        
        return redirect('admin/rooms')->with(
            'success', 'The room has been succesfully deleted!'
        );
    }
}
