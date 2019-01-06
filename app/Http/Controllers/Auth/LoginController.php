<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;;
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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/user-dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function login(Request $request)
    {
        if (Auth::attempt([ 'email' => $request->email, 'password' => $request->password])) {

            if (isset(request()->ref)){
                // Prevent double slash '//' if referring page is welcome page.
                $refUrl = (request()->ref === '/') ? '' : request()->ref;

                // Reconstruct referring page and redirect appropriately.
                $expected_path = config('app.url') . $refUrl;

                return redirect($expected_path);
            }

            return redirect()->route('user_dashboard');
        }
        
        flash('We could not sign you in, check your login credentials and try again.')->error();
        return redirect()->back();
    }

}
