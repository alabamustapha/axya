<?php

namespace App\Http\Controllers;

use App\Payout;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        // $this->middleware('doctoradmin');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Payout::class);
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
        $this->authorize('create', Payout::class);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payout  $payout
     * @return \Illuminate\Http\Response
     */
    public function show(Payout $payout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payout  $payout
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payout $payout)
    {
        //
    }
}
