<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Room;
use App\Models\User;
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
            'rooms', 'categories', 'views',
        ]));
    }

    public function show($id)
    {
        $room = Room::find($id);
        $categories = Category::all();
        $views = View::all();
        return view('user.show', compact([
            'room', 'categories', 'views',
        ]));
    }

    public function attach() {

    }

    public function book(Request $request, $id) {
        $request->validate([
            'start' => 'required|before:'.$request->finish,
            'finish' => 'required',
        ]);

        $room = Room::find($id);
        $start = strtotime($request->start);
        $finish = strtotime($request->finish);
        $time = ceil(abs($finish - $start) / 60 / 60);
        $totalPrice = $time * $room->rate;
        // Get all rooms with $id room_id
        $records = Room::find(1)->users->all();
        $flags = array();
        // Check if there are no users who booked this room
        if (!empty($records)) {
            // Check if there are any datetime intersects
            foreach ($records as $record) {
                $pivot_start = strtotime($record->pivot->start);
                $pivot_finish = strtotime($record->pivot->finish);
                array_push(
                    $flags,
                    !array_filter(array(
                        $pivot_start <= $start && $start <= $pivot_finish,
                        $pivot_start <= $finish && $finish <= $pivot_finish,
                        $start <= $pivot_start && $pivot_start <= $finish,
                        $start <= $pivot_finish && $pivot_finish <= $finish
                    )
                ));
            }
        } else {
            $flags = [true];
        }
        if (array_filter($flags) == $flags && $flags) {
            if ($totalPrice > auth()->user()->balance) {
                return redirect()->route('user.show', ['room' => $id])->withErrors([
                    'custom' => 'You do not have enough money on your balance!'
                ]);
            }

            $user = User::find(auth()->user()->id);
            $user->balance -= $totalPrice;
            $user->save();
    
            $room->users()->where(
                'id', auth()->user()->id
            )->attach(
                auth()->user()->id, [
                    'start' => date('Y-m-d H:i:s', $start),
                    'finish' => date('Y-m-d H:i:s', $finish),
                    'hours' => $time,
                    'total_price' => $totalPrice
                ]
            );

            return redirect()->route('user.show', ['room' => $id])->with(
                'success', 'You have been succesfully booked in!'
            );
        } else {
            $keys = array_keys(array_filter($flags, fn($var) => !$var));

            return redirect()->route('user.show', ['room' => $id])->withErrors(
                array_merge(
                    ['Rooms are taken between these datetimes: '],
                    array_map(function ($var) {
                        $records = Room::find(1)->users->all();
                        return $records[$var]->pivot->start.' - '.(
                            $records[$var]->pivot->finish
                        );
                    }, $keys)
                )
            );
        }
    }
}
