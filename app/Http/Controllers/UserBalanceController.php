<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserBalanceController extends Controller
{
    public function index($id)
    {
        if (auth()->user()->id != $id) {
            return redirect()->route('user.index');
        } else {
            $user = auth()->user();
            return view('user.balance.index', compact(['user']));
        }
    }

    public function update(Request $request, $id) {
        $request->validate([
            'balance' => 'required'
        ]);

        $user = User::find($id);
        $user->balance += $request->balance;
        $user->save();

        return redirect()->route('user.balance.index', $id)->with(
            'success', 'The balance has been succesfully updated!'
        );
    }

    public function reset($id) {
        $user = User::find($id);
        $user->balance = 0;
        $user->save();
        
        return redirect()->route('user.balance.index', $id)->with(
            'success', 'The balance has been succesfully reset!'
        );
    }
}
