<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Go to patient dashboard
     * 
     * @var User $user
     * 
     * @return view
     */

     public function dashboard(User $user){
        return view('patients.dashboard');
     }
}
