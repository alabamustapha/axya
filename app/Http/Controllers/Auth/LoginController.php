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
    

    /**
     * Logs user out of the app.
     * @see AuthenticatesUsers@login
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        if (Auth::attempt([ 'email' => $request->email, 'password' => $request->password])) {

            Auth::user()->logOutAsAdminOrDoctor();

            if (isset(request()->ref)){
                // Prevent double slash '//' if referring url is '/'.
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


    /**
     * Logs user out of the app.
     * @see AuthenticatesUsers@logout
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::user()->logOutAsAdminOrDoctor();

        Auth::logout();

        return redirect('/'); //->route('doctors.index') 
    }


    // /**
    //  * If user is admin/staff and is logged in as admin, log him out. 
    //  * Persistent admin log in could be due to session expiration.
    //  *
    //  * @return void
    //  */
    // public function logOutAsAdminOrDoctor()
    // {
    //     if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isStaff())) 
    //     {
    //         Auth::user()->update(['admin_mode' => 0]);
    //     }

    //     if (Auth::check() && (Auth::user()->isDoctor())) 
    //     {
    //         Auth::user()->update(['doctor_mode' => 0]);
    //     }
    // }

}
