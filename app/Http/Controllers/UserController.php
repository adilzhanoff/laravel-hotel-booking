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

        $min_rate = \DB::table('rooms')->min('rate');
        $max_rate = \DB::table('rooms')->max('rate');
        $used_categories = array();
        $used_views = array();

        foreach (Room::select('category_id')->distinct()->get()->all() as $used) {
            array_push(
                $used_categories,
                [$used->category_id, Category::find($used->category_id)->name]
            );
        }
        foreach (Room::select('view_id')->distinct()->get()->all() as $used) {
            array_push(
                $used_views,
                [$used->view_id, View::find($used->view_id)->name]
            );
        }

        return view('user.index', compact([
            'rooms', 'categories', 'views',
            'min_rate', 'max_rate', 'used_categories', 'used_views'
        ]));
    }

    public function filter(Request $request) {

        $filtered_categories = (
            empty($request->category) ?
            array_map(
                fn($var) => $var->category_id,
                Room::select('category_id')->distinct()->get()->all()
            ) :
            array_map(fn($var) => intval($var), $request->category)
        );
        $filtered_views = (
            empty($request->view) ?
            array_map(
                fn($var) => $var->view_id,
                Room::select('view_id')->distinct()->get()->all()
            ) :
            array_map(fn($var) => intval($var), $request->view)
        );
        $rooms = Room::where([
            ['rate', '>=', intval($request->price_start)],
            ['rate', '<=', intval($request->price_end)],
            ['description', 'like', '%'.$request->search.'%']
        ])->whereIn('category_id', array_map(
            fn($var) => intval($var), $filtered_categories
        ))->whereIn('view_id', array_map(
            fn($var) => intval($var), $filtered_views
        ))->get();

        $categories = Category::all();
        $views = View::all();

        $min_rate = $request->price_start;
        $max_rate = $request->price_end;
        $used_categories = array();
        $used_views = array();

        foreach (Room::select('category_id')->distinct()->get()->all() as $used) {
            array_push(
                $used_categories,
                [$used->category_id, Category::find($used->category_id)->name]
            );
        }
        foreach (Room::select('view_id')->distinct()->get()->all() as $used) {
            array_push(
                $used_views,
                [$used->view_id, View::find($used->view_id)->name]
            );
        }

        $selected_categories = array_intersect(
            $filtered_categories,
            array_map(
                fn($var) => $var[0],
                $used_categories
            )
        );
        $selected_views = array_intersect(
            $filtered_views,
            array_map(
                fn($var) => $var[0],
                $used_views
            )
        );

        foreach ($used_categories as $key => $category) {
            if (!empty($request->category)) {
                if (in_array($category[0], $selected_categories)) {
                    $used_categories[$key][2] = null;
                }
            }
        }
        foreach ($used_views as $key => $view) {
            if (!empty($request->view)) {
                if (in_array($view[0], $selected_views)) {
                    $used_views[$key][2] = null;
                }
            }
        }

        // dd($used_categories);

        return view('user.index', compact([
            'rooms', 'categories', 'views',
            'min_rate', 'max_rate', 'used_categories', 'used_views'
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
        $records = $room->users->all();
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
