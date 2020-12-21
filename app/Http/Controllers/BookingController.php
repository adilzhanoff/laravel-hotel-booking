<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index() {
        $bookings = \DB::table('users_rooms')->get();
        return view('admin.bookings.index', compact(['bookings']));
    }

    public function show($id) {
        $booking = \DB::table('users_rooms')->where('id', $id)->get()[0];
        return view('admin.bookings.show', compact(['booking']));
    }

    public function destroy($id) {
        \DB::table('users_rooms')->where('id', $id)->delete();

        return redirect()->route('admin.bookings.index')->with(
            'success', 'The booking has been succesfully deleted!'
        );
    }
}
