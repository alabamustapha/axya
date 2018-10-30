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
    protected $redirectTo = '/';

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
                'name'     => 'required|string|max:255',
                'email'    => 'required|string|email|max:255|unique:users',
                'gender'   => 'required|in:Male,Female,Other',
                'password' => 'required|string|min:6|confirmed',
                'dob'      => 'required|date|max:10',
                'terms'    => 'required|boolean',            
            ],
            [
                'gender.required' => 'You must select your gender',
                'gender.in'       => 'You can only choose from the avaiable gender select options.',
                'terms.required'  => 'You must accept the terms and conditions to be able to use our services.',
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
        // $is_doctor = isset($data['is_doctor']) && $data['is_doctor'] == 1 ? 1 : 0;
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'gender' => $data['gender'],
            'password' => Hash::make($data['password']),
            'dob'   =>  $data['dob'],
            'terms' =>  $data['terms'],
            // 'is_doctor' => $is_doctor,
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
        
        flash('A verification link was sent to '. $user->email .', kindly verify your account with the link. You may update your profile details now to be able to participate fully on '. config('app.name') .'.')->info()->important();

        Auth::login($user);
        return redirect()->route('patient_dashboard', $user);
    }
    
}
