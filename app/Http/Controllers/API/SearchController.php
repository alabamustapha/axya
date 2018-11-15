<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Doctor\DoctorResource;
use App\User;
use App\Doctor;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
      if (request()->q){
        $search = request()->q;

        // **with('doctor')** helps to link to relational *doctors* table for Vue rendering.
        $searches =  User::with('doctor')->whereHas('doctor') 
          ->where(function ($query) use ($search){
            $query->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
          })->paginate(5);
      }
      
      return $searches;
    }
}
