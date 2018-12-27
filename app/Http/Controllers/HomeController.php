<?php

namespace App\Http\Controllers;

use App\Doctor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctors = Doctor::isActive()->inRandomOrder()->get()->take(3);
        
        return view('welcome_2', compact('doctors'));
    }
    
    // public function search($path)
    // {
    //     return view('layouts.master');
    // }

    // public function home()
    // {
    //     return view('home');
    // }
}
