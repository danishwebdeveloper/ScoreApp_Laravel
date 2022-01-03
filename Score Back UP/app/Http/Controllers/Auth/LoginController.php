<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use DB;

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
    protected function authenticated(Request $request)
    {
        $default = DB::table('user_language')->where('user_id', Auth::user()->id)->get()->first();
        if(count($default) > 0)
        {
            set_language($default->locale);
        } 
        else
        {
            set_language('en');
        }

        if( Auth::user()->isSuperAdmin()) return redirect('admin_panel/dashboard');
        if( Auth::user()->isAdmin()) return redirect('admin/dashboard');
        if( Auth::user()->isManager()) return redirect('manager/dashboard');
        if( Auth::user()->isPlayer()) return redirect('player/dashboard');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
