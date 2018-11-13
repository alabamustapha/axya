<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard.index');
    }

    public function users()
    {
        return view('admin.dashboard.users');
    }

    public function doctors()
    {
        return view('admin.dashboard.doctors');
    }

    public function admins()
    {
        return view('admin.dashboard.admins');
    }

    public function transactions()
    {
        return view('admin.dashboard.transactions');
    }
}
