<?php

namespace heychum\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use heychum\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('/login');
        }
    }





    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';
    protected function authenticated($request, $user){
        // return $user;
        // return $user->role;
        if($user->role("member")){
            return 
            redirect('/profile')
            ->with('info', 'Logged in Successfully');

        }elseif($user->role('staff')){
            return 
            redirect('/admindashboard')
            ->with('info', 'Logged in Successfully');

        }elseif($user->role('admin')){
            return 
            redirect('/admindashboard')
            ->with('info', 'Logged in Successfully');
        } else {
            return redirect('/home');
        }
    }


    public function logout(Request $request) {
      Auth::logout();
      return redirect('/login');
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
