<?php

namespace App\Http\Controllers;

use App\UserLogin;
use Illuminate\Http\Request;
use App\Traits\UserLoginActivityRecording;

class UserLoginController extends Controller
{
    use UserLoginActivityRecording;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserLogin  $userLogin
     * @return \Illuminate\Http\Response
     */
    public function show(UserLogin $userLogin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserLogin  $userLogin
     * @return \Illuminate\Http\Response
     */
    public function edit(UserLogin $userLogin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserLogin  $userLogin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserLogin $userLogin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserLogin  $userLogin
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserLogin $userLogin)
    {
        //
    }
}
