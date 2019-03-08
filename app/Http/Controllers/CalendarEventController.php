<?php

namespace App\Http\Controllers;

use App\CalendarEvent;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

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

        $twoWeeksOffMonth = Carbon::parse(Carbon::now()->startOfMonth())->subWeeks(2);
        $twoWeeksAftMonth = Carbon::parse(Carbon::now()->endOfMonth())->addWeeks(2);
        // // If now is start/end of month, 3+- weeks events should be displayed.
        // $threeWeeksPast   = Carbon::now()->subWeeks(3);
        // $threeWeeksNext   = Carbon::now()->addWeeks(3);

        $events = 
          $user->calendar_events()
               ->where('start', '>=', $twoWeeksOffMonth)
               ->orWhere('start', '<=', $twoWeeksAftMonth)
               // ->orWhere('start', '>=', $threeWeeksPast)
               // ->orWhere('start', '<=', $threeWeeksNext)
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
     * Remove the specified resource from storage.
     *
     * @param  \App\CalendarEvent  $calendarEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(CalendarEvent $calendarEvent)
    {
        // Cron Job controlled for Appointmrnt and Transaction fee events.
        // Medication update or removal by user/patient.
    }
}
