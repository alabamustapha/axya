<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Notifications\Applications\ApplicationReceivedNotification;
use App\Notifications\Appointments\AppointmentAcceptedNotification;
use App\Notifications\Appointments\AppointmentBookedNotification;
use Illuminate\Http\Request;

class AppointmentStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('doctor')->only('accept','reject');
    }

    public function complete(Request $request, Appointment $appointment)
    {
        $this->authorize('edit', $appointment);
        $appointment->activateComplete();
        return response(['message' => 'Appointment/Consultation completed successfully.']);
    }

    public function accept(Request $request, Appointment $appointment)
    {
        $this->authorize('edit', $appointment);
        $appointment->activateAccept();
            
        // Doctor accepted, add fee payment to event table.
        $appointment->user
                     ->calendar_events()
                     ->create(\App\CalendarEvent::createTransactionEventData($appointment))
                     ;

        $appointment->user->notify(new AppointmentAcceptedNotification($appointment->user, $appointment));
        return response(['message' => 'Appointment accepted successfully.']);
    }

    public function reject(Request $request, Appointment $appointment)
    {
        $this->authorize('edit', $appointment);
        $appointment->activateReject();
        
        // $appointment->user->notify(new AppointmentRejetedNotification($appointment->user, $appointment));
        return response(['message' => 'Appointment rejected.']);
    }

    public function cancel(Request $request, Appointment $appointment)
    {
        $this->authorize('edit', $appointment);
        $appointment->activateCancel();
        return response(['message' => 'Appointment canceled.']);
    }

    public function payFee(Request $request, Appointment $appointment)
    {
        $this->authorize('edit', $appointment);
        // $appointment->activateFeePayment();
        $appointment->activateFeePayment();
        return response(['message' => 'Appointment consultation fee paid.']);
    }

    public function abscond(Request $request, Appointment $appointment)
    {
        $appointment->absconded();
        // $appointment->user()->penalize();
        return response(['message' => 'Appointment absconded by patient.']);
    }

    public function autocancel(Request $request, Appointment $appointment)
    {
        $appointment->autocancel();
        // $appointment->doctor()->penalize();
        
        // $appointment->user->notify(new AppointmentCanceledNotification($appointment->user, $appointment));
        return response(['message' => 'Appointment auto-cancelled by system after schedule elapses.']);
    }
}
