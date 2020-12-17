<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Http\Request;

class UserBalance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $user_id)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        dd($user_id);
        if (
            Role::find(auth()->user()->role_id)->name == 'user' &&
            auth()->user()->id == $user_id
        ) {
            return $next($request);
        } else {
            return redirect()->route('admin.rooms.index');
        }
    }
}
