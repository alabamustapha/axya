<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\AccountVerificationNotification;
use App\User;
use Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
                'firstname'     => 'required|string|max:255',
                'lastname'     => 'required|string|max:255',
                'email'    => 'required|string|email|max:255|unique:users',
                // 'gender'   => 'required|in:Male,Female,Other',
                'password' => 'required|string|min:6|confirmed',
                // 'dob'      => 'required|date|max:10',
                // 'terms'    => 'required|boolean',  
                'as_doctor' => 'required|boolean',   
            ],
            [
                // 'gender.required' => 'You must select your gender',
                // 'gender.in'       => 'You can only choose from the available gender select options.',
                // 'terms.required'  => 'You must accept the terms and conditions to be able to use our services.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // $as_doctor = isset($data['as_doctor']) && $data['as_doctor'] == 1 ? 1 : 0;

        $name = ucwords($data['firstname']) .' '. ucwords($data['lastname']);
        
        $user = User::create([
            'name'      => $name,
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            // 'gender'  => $data['gender'],
            // 'dob'    =>  $data['dob'],
            // 'terms'  =>  $data['terms'],
            // 'is_doctor' => $is_doctor,
            'as_doctor' => $data['as_doctor'],
        ]);

        return $user;
    }


    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * On ...\Illuminate\Foundation\Auth\RegistersUsers@register()
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $user->notify(new AccountVerificationNotification($user));

        $verLink = URL::temporarySignedRoute('verification.verify', \Carbon\Carbon::now()->addMinutes(60), ['id' => $user->id]);
        $user->update([ 'verification_link' => $verLink, ]);
        
        flash('A verification link was sent to '. $user->email .', kindly verify your account with the link. Update your profile details completely for a wider access on '. config('app.name') .'.')->info()->important();

        Auth::login($user);
        return redirect()->route('user_dashboard');
    }
    
}
