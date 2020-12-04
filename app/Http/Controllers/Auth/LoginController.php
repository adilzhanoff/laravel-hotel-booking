<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Models\Role;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    public function redirectTo() {
        if (Role::find(auth()->user()->role_id)['name'] == 'admin') {
            $this->redirectTo = '/admin/rooms';
            return $this->redirectTo;
        } else if (Role::find(auth()->user()->role_id)['name'] == 'user') {
            $this->redirectTo = '/user';
            return $this->redirectTo;
        } else {
            $this->redirectTo = '/register';
            return $this->redirectTo;
        }
    }

    public function logout() {
        auth()->logout();
        return redirect('login');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }
}
