<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\User;
use Carbon\Carbon;
use App\CalendarEvent;
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
        $this->middleware('auth')->only('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctors = Doctor::with(['region', 'city'])->active()->inRandomOrder()->get()->take(3);
        
        return view('welcome', compact('doctors'));
    }

    public function home()
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
        
        return view('home', 
        // return view('users.user-dashboard', 
            compact(
                'eventsCount',
                'medicationEventsCount',
                'transactionEventsCount',
                'patientAppointmentsCount',
                'doctorAppointmentsCount'
            ));
     }
}
