<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\UserLoginActivityRecording;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use UserLoginActivityRecording;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('admin')->only('index');
    }
    
    /**
     * Display a listing of the resource.
     * Just for reference usage, not need giving access to users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        // Use this to list a user's UserLogin list.
        $logins = UserLogin::where('user_id', $user);

        return response()->toJson($logins);
        // return view('logins.index', compact('user', 'logins'));
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
            // Others in AuthyEventSubscriber

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
        // Others in AuthyEventSubscriber

        Auth::logout();

        return redirect('/');
    }

}
