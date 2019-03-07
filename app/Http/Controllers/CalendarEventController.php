<?php

namespace App\Http\Controllers;

use App\CalendarEvent;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CalendarEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        $user = User::findOrFail($userId);
        // $eventingViewGrace = 6 months;//setting('event_view_period');
        // 2months back, 1 present, 3 months into future.

        // $threeMonthsPeriod = Carbon::parse($this->start_at)->addMonths($eventingViewGrace);

        $events = $user->calendar_events()
                       // {->whereIn('status', [1,3,5])
                       // ->where('end_at', '<', $threeMonthsPeriod)}
                       // ->active()
                       ->get([
                            'start', 
                            'end', 
                            'title', 
                            'content', 
                            'contentFull', 
                            'class', 
                            'icon', 
                            'background'
                        ])
                       ;

        return response()->json($events,  Response::HTTP_OK);//200
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
     * @param  \App\CalendarEvent  $calendarEvent
     * @return \Illuminate\Http\Response
     */
    public function show(CalendarEvent $calendarEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CalendarEvent  $calendarEvent
     * @return \Illuminate\Http\Response
     */
    public function edit(CalendarEvent $calendarEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CalendarEvent  $calendarEvent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CalendarEvent $calendarEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CalendarEvent  $calendarEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(CalendarEvent $calendarEvent)
    {
        //
    }
}
