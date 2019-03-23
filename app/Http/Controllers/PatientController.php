<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\CalendarEvent;
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

     public function dashboard()
     {
        $today = date('Y-m-d');

        $eventsCount = 
            CalendarEvent::where('user_id', auth()->id())
                ->where('start', 'like', "%$today%")
                ->count()
                ;
        $medicationEventsCount = 
            CalendarEvent::where('user_id', auth()->id())
                ->where('start', 'like', "%$today%")
                ->where('eventable_type', 'App\Medication')
                ->count()
                ;
        $transactionEventsCount = 
            CalendarEvent::where('user_id', auth()->id())
                ->where('start', 'like', "%$today%")
                ->where('eventable_type', 'App\Transaction')
                ->count()
                ;
        $patientAppointmentsCount = 
            CalendarEvent::where('user_id', auth()->id())
                ->where('start', 'like', "%$today%")
                ->where('eventable_type', 'App\Appointment')
                ->where('icon', 'fa-procedures')
                ->count()
                ;
        $doctorAppointmentsCount = 
            CalendarEvent::where('user_id', auth()->id())
                ->where('start', 'like', "%$today%")
                ->where('eventable_type', 'App\Appointment')
                ->where('icon', 'fa-user-md')
                ->count()
                ;
        return view('users.user-dashboard', 
            compact(
                'eventsCount',
                'medicationEventsCount',
                'transactionEventsCount',
                'patientAppointmentsCount',
                'doctorAppointmentsCount'
            ));
     }
}
