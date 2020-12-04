<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Room;
use Illuminate\Http\Request;

class AdminUsersController extends Controller
{
    public function index() {
        $users = User::where('id', '!=', auth()->id())->get();
        $roles = Role::all();
        return view('admin.users.index', compact(['users', 'roles']));
    }

    public function usersByRole($id) {
        $users = Role::find($id)->users->where('id', '!=', auth()->id());
        $roles = Role::all();
        return view('admin.users.index', compact(['users', 'roles']));
    }

    /* public function filterUsers($id) {
        $users = Role::find($id)->users->all();
        $roles = Role::all();
        return view('users.index', compact(['users', 'roles']));
    } */

    public function show($id) {
        $user = User::find($id);
        $rooms = $user->rooms->all();
        $all_rooms = Room::all();
        return view('admin.users.show', compact([
            'user', 'rooms', 'all_rooms'
        ]));
    }

    public function edit($id) {
        $user = User::find($id);
        $rooms = $user->rooms->all();
        $all_rooms = Room::all();
        return view('users.edit', compact([
            'user', 'rooms', 'all_rooms'
        ]));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'roles' => 'required',
            'rooms' => 'required'
        ]);

        try {
            $user = User::find($id);
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->save();

            $roles = Role::all();
            $ids = array();
            foreach ($roles as $role) {
                if (in_array($role->name, $request->get('roles'))) {
                    array_push($ids, $role->id);
                }
            }
            $user->roles()->sync($ids);

            $rooms = Room::all();
            $room_ids = array();
            foreach ($rooms as $room) {
                if (in_array($room->number, $request->get('rooms'))) {
                    array_push($room_ids, $room->id);
                }
            }
            $user->rooms()->sync($room_ids);
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return redirect('users/{user}/edit')->withErrors(
                    ['custom' => 'Account with such email already exists!']
                );
            }
        }

        return redirect('/users')->with(
            'success', 'The user has been succesfully edited!'
        );
    }

    public function destroy($id) {
        $user = User::find($id);
        $user->rooms()->detach();
        $user->delete();
        
        return redirect('admin/users')->with(
            'success', 'The user has been succesfully deleted!'
        );
    }
}
