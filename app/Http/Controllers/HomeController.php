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
        $doctors = Doctor::isActive()->get()->take(9);
        
        return view('welcome', compact('doctors'));
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
