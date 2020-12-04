<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\Role;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (Role::find(auth()->user()->role_id)->name != 'admin') {
            return redirect()->route('user.index');
        } else {
            return $next($request);
        }
    }
}
