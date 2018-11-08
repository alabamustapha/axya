<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Go to patient dashboard
     * 
     * @var User $user
     * 
     * @return view
     */

     public function dashboard(User $user){
        return view('');
     }
}
